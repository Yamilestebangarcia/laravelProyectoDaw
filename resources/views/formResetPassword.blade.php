<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> resetear contraseña  </title>
</head>
<body>
    <form action="{{route("resetPassword")}}" method="POST">
        @csrf
        <input type="text" name="email" placeholder="email">
        @error('email')
        <p>{{$message}}</p>
        @enderror
        <button type="submit">enviar</button>
    </form>
    @if (session("info"))
        <p>{{session("info")}} </p>
    @endif
</body>
</html>


