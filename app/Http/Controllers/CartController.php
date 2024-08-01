<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Le produit spécifié n\'existe pas.');
        }

        $duplicata = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->id;
        });

        if ($duplicata->isNotEmpty()) {
            return redirect()->route('products.index')->with('success', 'Le produit a déjà été ajouté.');
        }

        Cart::add($product->id, $product->title, 1, $product->price)
            ->associate('App\Models\Product');

        return redirect()->route('products.index')->with('success', 'Le produit a bien été ajouté.');
    }

    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        $stock = $request->input('stock');

        $validated = $request->validate([
            'qty' => 'required|numeric|between:1,5',
        ]);

        if ($data['qty'] > $stock) {
            return response()->json(['error' => 'La quantité demandée dépasse le stock disponible.'], 400);
        }

        Cart::update($rowId, $data['qty']);

        return response()->json([
            'success' => 'La quantité du produit a été mise à jour.',
            'subtotal' => Cart::subtotal(),
            'total' => Cart::total(),
        ]);
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Le produit a été supprimé.');
    }
}
