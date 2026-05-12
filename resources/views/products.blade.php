<!DOCTYPE html>
<html>
<head>
    <title>Mi tienda</title>
</head>
<body>

    <h1>🎸 Mi tienda de música</h1>

    <a href="/">Inicio</a> |
    <a href="/categories">Categorías</a>

    <hr>

    @foreach($products as $product)
        <div style="border:1px solid black; padding:10px; margin:10px;">
            <h2>{{ $product['name'] }}</h2>
            <p>Precio: ${{ $product['price'] }}</p>

            <a href="/products/{{ strtolower($product['name']) }}">
                Ver producto
            </a>
        </div>
    @endforeach

</body>
</html>