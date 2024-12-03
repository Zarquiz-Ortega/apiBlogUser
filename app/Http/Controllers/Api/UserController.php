<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(
                ['message' => 'No se encontraron elementos'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            UserResource::collection($users), 
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
            $user = User::create($request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|email|unique:users,email'
            ]));
            DB::commit();
            return response()->json(
                $user,
                Response::HTTP_CREATED
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
    public function show(User $user)
    {
        try {
            return response()->json(
                UserResource::make($user),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                ['message' => 'Error al hacer la operacion: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $user = User::findOrFail($id);

            $validateRequest = $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|email|unique:users,email,'. $id,
            ]);

            $user->update($validateRequest);

            DB::commit();

            return response()->json(
                UserResource::make($user),
                Response::HTTP_OK
            );

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(
                ['message' => 'Error al actualizar el reguistro: '. $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
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
