<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::get();

        return TaskResource::collection($tasks);
    }

    public function getAllTasks()
    {
        $tasks = Task::with('user')->get();
        $users = User::with('role')->where('role_id', '!=', Auth::id())->get();

        return response()->json([
            'tasks' => TaskResource::collection($tasks),
            'users' => UserResource::collection($users)
        ]);
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = Task::PENDING_STATUS;
            $task->user_id = $request->user_id;
            $task->save();

            return response()->json(['message' => 'Tarea guardada correctamente'], Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al guardar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('comments');

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        try {
            $task->title = $request->title;
            $task->description = $request->description;
            $task->user_id = $request->user_id;
            $task->status = $request->status;

            if($task->isDirty()) {
                $task->save();
            }
            return response()->json([ 'message' => 'Tarea actualizada correctamente'], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al actualizar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json([ 'message' => 'Tarea eliminada correctamente'], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al eliminar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('owner', $task);

        try {
            $task->status = $request->status;
            $task->save();

            return response()->json([ 'message' => 'Estado actualizado correctamente'], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al actualizar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }
}
