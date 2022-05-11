<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile</title>
</head>
<body>
<h1>Profile</h1>
<div>
    <h3>OAuth info:</h3>
    <h4>Vk:</h4>
    <label>
        <b> Last login date: {{ $user['vkontakte_logged_in_at'] }}</b>
        <b> Registered date: {{ $user['vkontakte_registered_at'] }}</b>
    </label>
    <h4>Google:</h4>
    <label>
        <b> Last login date: {{ $user['google_logged_in_at'] }}</b>
        <b> Registered date: {{ $user['google_registered_at'] }}</b>
    </label>
</div>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
