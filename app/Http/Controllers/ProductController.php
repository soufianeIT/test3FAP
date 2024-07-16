<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    //    $products = Product::inRandomOrder()->take(8)->get();
    if (request()->categorie) {
        $products = Product::with('categories')->whereHas('categories', function ($query) {
            $query->where('slug', request()->categorie);
        })->paginate(6);
    } else {
        $products = Product::with('categories')->paginate(6);
    }

    return view('products.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $stock = $product->stock === 0 ? 'Indisponible' : 'Disponible';

        return view('products.show', [
            'product' => $product,
            'stock' => $stock
        ]);
    }

    public function search()
    {
        request()->validate([
            'q' => 'required|min:3'
        ]);

        $q = request()->input('q');

        $products = Product::where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->paginate(6);

        return view('products.search')->with('products', $products);
    }
}
