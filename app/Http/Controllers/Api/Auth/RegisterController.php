<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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

            $user = User::insert([
                'nama' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'trash' => $request->trash,
                'id_owner' => $request->id_owner,
                'activation_code' => rand(100000, 999999),
                'fcm_token' => Str::random(152),
                'reveral' => Str::random(6),
            ]);
            // $user->save();

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
