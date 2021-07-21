<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'username' => 'required|string|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|string',
        ]);

        // Add in database
        try {
            $user = new User;
            $user->username = $request->input('username');
            $user->password = app('hash')->make($request->input('password'));
            $user->role = $request->input('role');
            $user->save();

            return response()->json([
                'message' => 'User successfully registered.',
                'success' => true,
                'code' => 201,
            ], 201);
        }

        catch(\Exception $e) {
            return response()->json([
                'message' => 'Error while registering user.',
                'success' => false,
                'code' => 409,
            ], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */	
    public function login(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if(!$token = Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized.',
                'success' => false,
                'code' => 401,
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get user details.
     *
     * @param  Request  $request
     * @return Response
     */	
    public function me()
    {
        return response()->json([
            'data' => auth()->user(),
            'success' => true,
            'code' => 200,
        ], 200);
    }

    /**
     * Get all users
     * 
     * @param  Request $request
     * @return Response
     */
    public function getAllUsers()
    {
        return response()->json([
            'data' => User::all(),
            'success' => true,
            'code' => 200,
        ], 200);
    }
}
