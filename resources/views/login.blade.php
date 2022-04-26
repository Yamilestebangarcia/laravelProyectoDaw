@extends('plantilla')

@section('titulo')
    login
@endsection

@section('contenido')
    <form action="" method="POST">
        @csrf
        <input type="text" placeholder="email" name="email" value="{{old("email")}}">
        @error('email')
            <p>{{$message}}</p>
        @enderror
        <input type="password" placeholder="password" name="password">
        @error("password")
        <p>{{$message}}</p>
        @enderror
    
        <button type="submit">login</button> 
    </form>
<a href="{{route("formReset")}}">¿has olvidado la contraseña?</a>
@if (session("info"))
<p>{{session("info")}} </p>
@endif
@endsection