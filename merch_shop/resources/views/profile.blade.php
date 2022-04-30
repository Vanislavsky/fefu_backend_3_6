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
    @if($login_way == 'vkontakte')
        <h3>OAuth info:</h3>
        <h4>Github:</h4>
        <label>
            <b> Last login date: {{ $user['vkontakte_logged_in_at'] }}</b>
            <b> Registered date: {{ $user['vkontakte_registered_at'] }}</b>
        </label>
    @elseif($login_way == 'google')
        <h3>OAuth info:</h3>
        <h4>Google:</h4>
        <label>
            <b> Last login date: {{ $user['google_logged_in_at'] }}</b>
            <b> Registered date: {{ $user['google_registered_at'] }}</b>
        </label>
    @endif
</div>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
