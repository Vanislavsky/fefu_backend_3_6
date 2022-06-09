<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Каталог</title>
</head>
<body>
<div>
    <form method="GET">
        <div>
            <label for="search_query">Search</label>
            <input type="text" name="search_query" id="search_query" value="{{ request('search_query') }}">
        </div>
        <div>
            <label for="sort_mode">Sort mode</label>
            <select name="sort_mode" id="sort_mode">
                <option value="price_asc">price asc</option>
                <option value="price_desc">price desc</option>
            </select>
        </div>
        @foreach($filters as $filter)
            <div>
                <h4>{{ $filter->name }}</h4>
                @foreach($filter->options as $option)
                    <div>
                        <label>
                            <input type="checkbox" value="{{ $option->value }}"
                                   name="filters[{{ $filter->key }}][]" {{ $option->isSelected ? 'checked' : '' }}>
                            {{ $option->value }} ({{ $option->productCount }} )
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button>Apply</button>
    </form>
    Каталог
    @include('catalog.catalog_list', ['categories', $categories])

    @foreach ($products as $product)
        <article>
            <a href="{{ route('product', $product->slug) }}">
                <h3>{{ $product->name }}</h3>
            </a>
            <p>{{ $product->price }} руб.</p>
        </article>
    @endforeach

    {{ $products->links() }}
</div>
</body>
</html>
