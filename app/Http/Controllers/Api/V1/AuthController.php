<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @group Auth
     * @bodyParam name string required. Example: Joao
     * @bodyParam email string  required. Example: john@mail.com
     * @bodyParam password string required.
     * @bodyParam password_confirmation string required.
     * @response 200 {
     *   "token": "urbfjdj83jdjsjjsudjsis838euue",
     *   "user": {
     *      "id": 1,
     *      "name": John,
     *      "email": "email@mail.com",
     *  }
     * }
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:5'],
            'password_confirmation' => ["required"]
        ]);

        $user = User::query()->create($validated);
        $token = $user->createToken("api_token")->plainTextToken;

        if ($user) {
            return response()->json([
                "status" => 201,
                "user" => $user,
                "token" => $token
            ], 201);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Ocorreu um erro ao fazer o cadastro'
        ], 500);
    }

    /**
     * @group Auth
     * @bodyParam email string  required. Example: john@mail.com
     * @bodyParam password string.
     * @response 200 {
     *   "token": "urbfjdj83jdjsjjsudjsis838euue",
     *   "user": {
     *      "id": 1,
     *      "name": John,
     *      "email": "email@mail.com",
     *  }
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5']
        ]);

        $authenticated = Auth::attempt($credentials);

        if ($authenticated) {
            $user = User::query()->whereEmail($credentials['email'])->first();
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                "status" => 200,
                "user" => $user,
                "token" => $token
            ], 200);
        }

        return response()->json([
            'message' => 'As credenciais que informou são inválidas'
        ], 404);
    }

    /**
     * @group Auth
     * @Authenticated
     * @response 200 {
     *   "message": "Sessão terminada com sucesso"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()?->tokens()?->delete();

        return response()->json([
            'message' => 'Sessão terminada com sucesso'
        ], 200);
    }
}
