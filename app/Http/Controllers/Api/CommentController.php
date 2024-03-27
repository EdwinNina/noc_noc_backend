<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentFormRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getCommentsByTask(Request $request)
    {
        $comments = Comment::where('task_id', $request->task_id)->get();

        return CommentResource::collection($comments);
    }

    public function store(CommentFormRequest $request)
    {
        try {
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->task_id = $request->task_id;
            $comment->user_id = Auth::id();
            $comment->save();

            return response()->json(['message' => 'Comentario guardada correctamente'], Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al guardar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }
}
