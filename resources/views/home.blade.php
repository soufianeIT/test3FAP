@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white fw-bold">Mes commandes</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @forelse (Auth()->user()->orders ?? [] as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                Commande passée le {{ Carbon\Carbon::parse($order->payment_created_at)->format('d/m/Y à H:i')}} d'un montant de <strong>{{ getFormattedPrice($order->amount) }}</strong>
                            </div>
                            <div class="card-body">
                                <h6>Liste des produits</h6>
                                @foreach (json_decode($order->products) as $product)
                                    <div>Nom du produit: {{ $product->title }}</div>
                                    <div>Prix: {{ getFormattedPrice($product->price) }}</div>
                                    <div>Quantité: {{ $product->qty }}</div>
                                @endforeach
                                @if (Auth()->user())
                                    <a href="{{ route('order.downloadPdf', $order->id) }}" class="btn btn-primary mt-3">
                                        Télécharger PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Vous n'avez pas encore passé de commande.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
