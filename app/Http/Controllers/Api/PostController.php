<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        dd($posts);
        if ($posts->isEmpty()) {
            return response()->json(
                ['message' => 'No se encontraron registros'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            $posts,
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        DB::beginTransaction();
        try {
            $post =  Post::create($request->validated([
                'title' => 'require|string',
                'body' => 'require|string',
                'blog_id' => 'require',
            ]));
            DB::commit();
            return response()->json(
                PostResource::make($post),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al realizar la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            return response()->json(
                PostResource::make($post),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                ['message' => 'Error al realizar la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        DB::beginTransaction();
        try {
            $post->update($request->validate([
                'title' => 'require|string',
                'body' => 'require|string',
                'blog_id' => 'require',
            ]));
            DB::commit();
            return response()->json(
                PostResource::make($post),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al realizar la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al realizar la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
