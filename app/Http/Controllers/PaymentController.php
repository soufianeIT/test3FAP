<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Stripe\Service\ProductService;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        if (Cart::count() <= 0) {
            return redirect()->route('products.index');
        }

        $stripeSecretKey = 'sk_test_51PVat9GGsWfm58hQAbugq0QO53mB6OZXssrp2CTrCnfXn0PXRqprQvtTjBUz4uViOdBR5QxjWBa0iQOcu0vaMekc00fN0zkSQL';

        Stripe::setApiKey($stripeSecretKey);

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'eur',
        ]);

        $clientSecret = Arr::get($intent, 'client_secret');

        return view('payment.index', [
            'clientSecret' => $clientSecret
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if ($this->checkIfNotAvailable()) {
            Session::flash('error', 'Un produit dans votre panier n\'est plus disponible.');
            return response()->json(['success' => false], 400);
        }

        $data = $request->json()->all();

        // Ajoutez des logs pour le débogage
        Log::info('Données reçues pour la commande', $data);

        try {
            $order = new Order();

            $order->payment_intent_id = $data['paymentIntent']['id'];
            $order->amount = $data['paymentIntent']['amount'];

            $order->payment_created_at = (new DateTime())
                ->setTimestamp($data['paymentIntent']['created'])
                ->format('Y-m-d H:i:s');

            $products = [];
            $i = 0;

            foreach (Cart::content() as $product) {
                $products['product_' . $i]['title'] = $product->model->title;
                $products['product_' . $i]['price'] = $product->model->price;
                $products['product_' . $i]['qty'] = $product->qty;
                $i++;
            }

            $order->products = json_encode($products); // Utilisation de json_encode au lieu de serialize
            $order->user_id = auth()->id(); // Utiliser l'ID de l'utilisateur authentifié
            $order->save();

            // Vérifiez que l'ordre est bien sauvegardé
            Log::info('Order sauvegardé', ['order_id' => $order->id]);

            if ($data['paymentIntent']['status'] === 'succeeded') {
                $this->updateStock();
                Cart::destroy();
                Session::flash('success', 'Votre commande a été traitée avec succès.');
                return response()->json(['success' => 'Payment Intent Succeeded']);
            } else {
                return response()->json(['error' => 'Payment Intent Not Succeeded']);
            }
        } catch (\Exception $e) {
            // Loguer les erreurs
            Log::error('Erreur lors de la sauvegarde de la commande', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors de la traitement de la commande'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function checkIfNotAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);

            if ($product->stock < $item->qty) {
                return true;
            }
        }

        return false;
    }

    private function updateStock()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }
}
