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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Vérifier si le produit existe
        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Le produit spécifié n\'existe pas.');
        }

        // Rechercher un produit duplicata dans le panier
        $duplicata = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->id;
        });

        if ($duplicata->isNotEmpty()) {
            return redirect()->route('products.index')->with('success', 'Le produit a déjà été ajouté.');
        }

        // Ajouter le produit au panier
        Cart::add($product->id, $product->title, 1, $product->price)
            ->associate('App\Models\Product');

        return redirect()->route('products.index')->with('success', 'Le produit a bien été ajouté.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $rowId)
    {
        //
        $data = $request->json()->all();

        // $validates = Validator::make($request->all(), [
        //     'qty' => 'numeric|required|between:1,5',
        // ]);

        // if ($validates->fails()) {
        //     Session::flash('error', 'La quantité doit est comprise entre 1 et 5.');
        //     return response()->json(['error' => 'Cart Quantity Has Not Been Updated']);
        // }

        if ($data['qty'] > $data['stock']) {
            Session::flash('error', 'La quantité de ce produit n\'est pas disponible.');
            return response()->json(['error' => 'Product Quantity Not Available']);
        }

        Cart::update($rowId, $data['qty']);

        Session::flash('success', 'La quantité du produit est passée à ' . $data['qty'] . '.');
        
        return response()->json(['success' => 'Cart Quantity Has Been Updated']);

    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Le produit a été supprimé.');
    }
}
