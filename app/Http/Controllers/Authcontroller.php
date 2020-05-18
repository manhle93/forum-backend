<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class Authcontroller extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'dangKy']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user_name' => auth()->user()->name
        ]);
    }
    public function dangKy(Request $request){

            $password = Hash::make($request->get('password'));
            $email = $request->get('email');
            $name = $request->get('name');
            $data = $request->all();
            $validator = Validator::make($data, [
                'email' => 'required|email',
                'name'  => 'required',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => __('Không thể đăng ký'),
                    'data' => [
                        $validator->errors()->all(),
                    ],
                ], 400);
            }
            $password = Hash::make($data['password']);
            try{
              User::create(['name'=> $data['name'], 'email' => $data['email'], 'password' => $password]);
              return response(['message' => "Đăng ký thành công "], 200);
            }
            catch(\Exception $e){
                return response(['message' => "Lỗi ".$e], 500);
            }
            
    }
}
