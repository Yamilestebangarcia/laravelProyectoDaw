@extends('plantilla')

@section('titulo')
  registro
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
     {{--    <input type="password_confirmation" placeholder="password"> la ponemos??? --}}
        <button type="submit">registro</button> 
    </form>
@endsection