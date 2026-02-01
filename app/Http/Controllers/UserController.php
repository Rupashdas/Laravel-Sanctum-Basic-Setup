<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    /*
    Register User
     */
    public function register(Request $request) {
        $request->validate([
            "name"     => "required",
            "email"    => "required|email|unique:users",
            "password" => "required",
        ]);

        $user = User::create([
            "name"     => $request->input("name"),
            "email"    => $request->input("email"),
            "password" => Hash::make($request->input("password")),
        ]);

        return response()->json([
            "user" => $user,
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            "email"    => "required|email",
            "password" => "required",
        ]);

        $user = User::where("email", $request->input("email"))->first();
        if (!$user) {
            return response()->json([
                "message" => "User Not found",
                "status"  => "failed",
            ]);
        }

        if (!Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "message" => "Invalid Password",
                "status"  => "failed",
            ]);
        }

        $token = $user->createToken("token")->plainTextToken;
        return response()->json([
            "message" => "Login successful",
            "status"  => "success",
            "token"   => $token,
        ]);

    }

    function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "Logout successful",
            "status"  => "success",
        ]);
    }

    function profile(Request $request) {
        return response()->json([
            $request->user(),
        ]);
    }

}
