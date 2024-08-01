<!DOCTYPE html>
<html>
<head>
    <title>Commande #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .order-details {
            margin: 20px;
        }
        .product {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="order-details">
        <h1>Commande #{{ $order->id }}</h1>
        <p>Date de la commande : {{ \Carbon\Carbon::parse($order->payment_created_at)->format('d/m/Y à H:i') }}</p>
        <p>Montant total : {{ getFormattedPrice($order->amount) }}</p>

        <h2>Liste des produits</h2>
        @foreach (json_decode($order->products) as $product)
            <div class="product">
                <div><strong>Nom du produit :</strong> {{ $product->title }}</div>
                <div><strong>Prix :</strong> {{ getFormattedPrice($product->price) }}</div>
                <div><strong>Quantité :</strong> {{ $product->qty }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
