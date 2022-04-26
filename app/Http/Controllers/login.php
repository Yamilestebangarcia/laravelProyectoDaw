<?php

namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Mail\mailToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use Illuminate\Support\Facades\Mail;
use Exception;

class login extends Controller
{
    public function main()
    {
        return view("main");
    }
    public function registro()
    {
        return view("registro");
    }
    public function registroPost(RegistroRequest $request)
    {    //session fixation
        request()->session()->regenerate();
        if (isset($request->password)) {

            $user = User::create(["email" => $request->email, "password" => $request->password]);
            auth()->login($user);
            return redirect()->route("main");
        }
        return "mandar email con jwt";
    }

    public function login()
    {
        return view("login");
    }
    public function loginPost(LoginRequest $request)
    {

        $credenciales = array("email" => $request->email, "password" => $request->password);
        if (Auth::attempt($credenciales)) {
            //session fixation
            request()->session()->regenerate();
            return redirect()->route("main");
        }
        return redirect()->route("login");
    }
    public function cerrar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login");
    }
    public function formResetPassword()
    {
        return view("formResetPassword");
    }
    public function resetPassword(Request $request)
    {
        request()->session()->regenerate();
        $request->validate(['email' => 'required|email']);

        $user = DB::table('users')->where("email", "=", $request->email)->get();
        if (isset($user[0])) {
            $fecha = new  DateTimeImmutable();
            $key = env('JWT_SECRET');
            $expire = $fecha->modify(env("JWT_EXPIRE"))->getTimestamp();

            $data  = [
                "id" => $user[0]->id,
                'iat' => $fecha->getTimestamp(),
                'nbf' => $fecha->getTimestamp(),
                "exp" => $expire
            ];
            $jwt = JWT::encode($data, $key, 'HS256');

            $correo = new mailToken($jwt);
            Mail::to($user[0]->email)->send($correo);
            //mensaje  y redrijo

        }
        return  redirect()->route("formReset")->with("info", "Email enviado");
        //  

        //  print_r($decoded);


    }
    public function formPasswordEmail($jwt)
    {

        return view("formPasswordEmail", compact("jwt"));
    }
    public function changePassword(changePasswordRequest $request)
    {
        request()->session()->regenerate();
        if (isset($request->jwt)) {
            $key = env('JWT_SECRET');
            try {
                $data = JWT::decode($request->jwt, new Key($key, 'HS256'));
            } catch (Exception  $err) {
                print($err);
                //   return redirect()->route("emailjwt", $request->jwt)->with("info", "token invalido");
            }
            // print_r($data->id);
            $passEncry = bcrypt($request->password);
            $user = User::find($data->id);

            $user->password = $passEncry;
            $user->save();

            return redirect()->route("login", $request->jwt)->with("info", "la contraseña se ha cambiado");
        }
        return redirect()->route("emailjwt", $request->jwt)->with("info", "no existe el token");

        return "s";
    }
}
