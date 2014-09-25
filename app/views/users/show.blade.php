<!DOCTYPE html>
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> Datos de usuario </title>
 </head>
 <body>
    <h1> {{ $users->users_nombre }} </h1>
    <ul>
       <li> Nombre de usuario: {{ $users->users_nombre }} </li>
       <li> Email: {{ $users->users_email }} </li>
       <li> Nivel: {{ $users->users_nivel }} </li>
       <li> Activo: {{ ($users->users_activo) ? 'Sí' : 'No' }} </li>
    </ul>
    <p> {{ link_to('users', 'Volver atrás') }} </p>
 </body>
</html>