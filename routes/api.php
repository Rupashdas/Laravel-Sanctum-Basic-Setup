<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);
Route::middleware('auth:sanctum')->post("/logout", [UserController::class, "logout"]);
Route::get("/profile", [UserController::class, "profile"])->middleware('auth:sanctum');