<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Login
     * @OA\Post (
     *     path="/api/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"user@example.com",
     *                     "password":"user1"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object", 
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example=null),
     *              ),
     *              @OA\Property(property="data", type="object", 
     *                  @OA\Property(property="user", type="object", 
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="name", type="string", example="User"),
     *                      @OA\Property(property="email", type="string", example="user@example.com"),
     *                      @OA\Property(property="email_verified_at", type="string", example=null),
     *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *                  ),
     *                  @OA\Property(property="access_token", type="object", 
     *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
     *                      @OA\Property(property="type", type="string", example="Bearer"),
     *                      @OA\Property(property="expires_in", type="number", example=3600),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */

    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->validated());
        if (!$token)
        {
            return errorResponse([], 'Incorrect username or password!', 401);
        }

        return successResponse([
            'user' => auth()->user(),
            'access_token' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
        ]);

    }

    public function register(RegisterRequest $request)
    {
        $request = $request->validated();

        $user = $this->user::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $token = auth()->login($user);
        return successResponse([
            'user' => $user,
            'access_token' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
        ], 'User created successfully');
    }

    public function logout()
    {
        auth()->logout();
        return successResponse([], 'Successfully logged out');
    }

    public function refresh()
    {
        return successResponse([
            'user' => Auth::user(),
            'access_token' => [
                'token' => Auth::refresh(),
                'type' => 'Bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ]);
    }
}
