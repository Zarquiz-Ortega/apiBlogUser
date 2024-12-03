<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();

        if ($comments->isEmpty()) {
            return response()->json(
                ['message' => 'No se encontraron reguistros'],
                Response::HTTP_NOT_FOUND
            );
        }
        return response()->json(
            CommentResource::collection($comments),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::create($request->validate([
                'body'=> 'required|string',
                'user_id' => 'required',
                'post_id' => 'required'
            ]));
            DB::commit();
            return response()->json(
                CommentResource::make($comment),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al crear el registro: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        try {
            return response()->json(
                CommentResource::make($comment),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                ['message' => 'Error al crear el registro: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->update($request->validate([
                'body'=> 'required|string'
            ]));
            DB::commit();
            return response()->json(
                CommentResource::make($comment),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al crear el registro: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al crear el registro: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
