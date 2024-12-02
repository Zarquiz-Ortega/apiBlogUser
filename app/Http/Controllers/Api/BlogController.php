<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        if ($blogs->isEmpty()) {
            return response()->json(
                ['message' => 'No se encontraron registros'],
                Response::HTTP_NOT_FOUND
            );
        }
        return response()->json(
            $blogs,
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        DB::beginTransaction();;
        try {
            $validateRequest = $request->validate([
                'name' => 'required|string|min:3|max:255',
                'url' => 'required|string',
                'user_id' => 'required|unique:blogs,user_id'
            ]);

            $blog = $user->blog()->create($validateRequest);

            DB::commit();
            return response()->json(
                $blog,
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
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try {
            return response()->json(
                $blog,
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
    public function update(Request $request, Blog $blog)
    {
        DB::beginTransaction();
        try {
            $blog->update($request->validate([
                'name' => 'required|string|min:3|max:255',
                'url' => 'required|string',
            ]));
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
    public function destroy(string $id)
    {
        try {
            //code...
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ['message' => 'Error al realizar la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
