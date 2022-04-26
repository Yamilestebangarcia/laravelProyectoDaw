<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cambiar contraseña</title>
    <meta name="autor" content="Yamil Esteban Garcia">
    <meta http-equiv="Cache-control" content="max-age=2592000">
</head>
<body>
   
        <form action="{{route("changePassword")}}" method="POST">
        @csrf
        <input type="hidden" value="{{$jwt}}" name="jwt"/>
        <input type="password" placeholder="contraseña" name="password">
        @error('password')
            <p>{{$message}}</p>
        @enderror
        <button type="submit">cambiar</button>
    </form>
    @if (session("info"))
    <p>{{session("info")}} </p>
    @endif
</body>
</html>