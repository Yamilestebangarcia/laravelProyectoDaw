@extends('plantilla')

@section('contenido')
<form action="{{route("cerrarSesion")}}" method="POST">
    @csrf
<button type="submit">cerrar sesion</button>
</form>
 
  {{--   @guest
        vista de invitado 
    @endguest --}}
    @auth
    {{auth()->user()->email}}
    {{-- forma de obtener el email o el tipo de usuario en un futuro --}}
        main estas autenticado
    @endauth
@endsection