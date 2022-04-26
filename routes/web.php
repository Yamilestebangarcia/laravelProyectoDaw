<?php

use App\Http\Controllers\login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("login", [login::class, "login"])->middleware("guest")->name("login");
Route::post("login", [login::class, "loginPost"]);

Route::get("main", [login::class, "main"])->name("main")->middleware("auth");
Route::get("registro", [login::class, "registro"]);
Route::post("registro", [login::class, "registroPost"]);
Route::post("cerrar", [login::class, "cerrar"])->name("cerrarSesion");
Route::get("formResetPassword", [login::class, "formResetPassword"])->name("formReset");
Route::post("resetPassword", [login::class, "ResetPassword"])->name("resetPassword");
Route::get("formPasswordEmail/{jwt}", [login::class, "formPasswordEmail"])->name("emailjwt");
Route::post("changePassword", [login::class, "changePassword"])->name("changePassword");
