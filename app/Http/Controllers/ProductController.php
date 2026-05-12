<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            ['name' => 'Guitarra', 'price' => 1500],
            ['name' => 'Batería', 'price' => 3000],
            ['name' => 'Piano', 'price' => 5000],
        ];

        return view('products', compact('products'));
    }

    public function show($slug)
    {
        return "<h1>Producto: " . $slug . "</h1><a href='/products'>Volver</a>";
    }

    public function categories()
    {
        return "<h1>Categorías</h1><p>Aquí van las categorías</p>";
    }
}