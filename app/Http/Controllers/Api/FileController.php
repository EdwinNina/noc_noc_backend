<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileFormRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getFilesByTask(Request $request)
    {
        $files = File::where('task_id', $request->task_id)->get();

        return FileResource::collection($files);
    }

    public function store(FileFormRequest $request)
    {
        try {
            $file = new File();
            $file->task_id = $request->task_id;
            $fileUrl = $request->file('file')->store('tasks', 'public');
            $file->url = $fileUrl;
            $file->user_id = Auth::id();
            $file->save();

            return response()->json(['message' => 'Archivo guardada correctamente'], Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al guardar el archivo, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(File $file)
    {
        $this->authorize('canDeleteFile', $file);

        try {
            if(Storage::disk('public')->exists($file->url)){
                Storage::disk('public')->delete($file->url);
            }
            $file->delete();
            return response()->json(['message' => 'Archivo eliminado correctamente'], Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al borrar el archivo, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }
}
