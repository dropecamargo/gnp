<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
</head>
<body>
    <div class="welcome">
        <h1>Bienvenido {{ Auth::user()->name; }}</h1>
		{{ HTML::link('/logout', 'Cerrar sesión.') }}
    </div>
</body>
</html>