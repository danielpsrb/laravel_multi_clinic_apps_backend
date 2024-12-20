<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;    // User Model
use Illuminate\Support\Facades\Hash;    // Hash Library

class UserController extends Controller
{
    //get data user by email
    public function index($email)
    {
        $user = User::where('email', $email)->first();
        if(!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User found',
            'data' => $user
        ], 200);
    }

    //update Google Id
    public function updateGoogleId(Request $request, $id)
    {
        $request->validate([
            'google_id' => 'required'
        ]);

        $user = User::find($id);

        if ($user) {
            $user->google_id = $request->google_id;
            $user->save();

            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }

    //update data user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'google_id' => 'required',
            'ktp_number' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
        ]);

        $data = $request->all();
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    //check user email
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email already registered',
                'valid' => false
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Email not registered',
                'valid' => true
            ], 404);
        }
    }

    //login handle logic
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // $email = $request->email;
        $password = $request->password;

        //cari data user yang akan login berdasarkan email
        $user = User::where('email', $loginData['email'])->first();

        //check if user exists
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        //check validate password is correct
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
                'data' => null
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    //logout handle logic
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout success'
        ], 204);
    }

    //store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $data = $request->all();
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $role = $request->role;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created',
            'data' => $user
        ], 201);
    }
}
