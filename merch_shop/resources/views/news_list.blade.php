<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
@foreach ($news_list as $news)
    <h1>{{ $news->title }}</h1>
    <p>{{ $news->text }}</p>
    @isset($news->published_at)
        <p align="right">{{ $news->published_at }}</p>
    @endisset
@endforeach

{{ $news_list->links() }}
</body>
</html>
