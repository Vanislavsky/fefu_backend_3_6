<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Вход</title>
</head>
<body>
<h1>OAuth login failed</h1>
<p>{{ $provider }} auth failed</p>
<p>{{ $error }}</p>
</body>
</html>
