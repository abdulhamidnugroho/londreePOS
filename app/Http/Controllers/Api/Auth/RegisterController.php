<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Create User
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        // dd($request->all());
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'trash' => $request->trash,
            ]);
            $user->save();

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to register user, please try again. {$exception->getMessage()}"
            ], 500);
        }

        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}
