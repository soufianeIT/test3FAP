@extends('layouts.apps')

@section('title', 'Bag')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@if (Cart::count() > 0)
<div class="px-4 px-lg-0">
    <div class="pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <div class="p-5 bg-white rounded shadow-sm">
                        <!-- Shopping cart table -->
                        <h1>Mon panier</h1>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Produit</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Prix</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantité</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Supprimer</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $product)
                                    <tr>
                                        <th scope="row" class="border-0">
                                            <div class="p-2">
                                                <img src="{{ $product->model->image }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                <div class="ml-3 d-inline-block align-middle">
                                                    <h5 class="mb-0"> <a href="{{ route('products.show', ['slug' => $product->model->slug]) }}" class="text-dark d-inline-block align-middle">{{ $product->model->title }}</a></h5>
                                                    <span class="text-muted font-weight-normal font-italic d-block">Category:</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="border-0 align-middle"><strong>{{ getFormattedPrice($product->subtotal()) }}</strong></td>
                                        <td class="border-0 align-middle">
                                            <select class="custom-select" name="qty" id="qty_{{ $product->rowId }}" data-row-id="{{ $product->model->stock }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ $product->qty == $i ? 'selected' : ''}}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td class="border-0 align-middle">
                                            <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                </svg></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Shopping cart table -->
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Résumé de commande</div>
                        <div class="p-4">
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-Total</strong><strong>{{ getFormattedPrice(Cart::subtotal()) }}</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Taxe(21%)</strong><strong>{{ getFormattedPrice(Cart::tax()) }}</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong><h5 class="font-weight-bold">{{ getFormattedPrice(Cart::total()) }}</h5></li>
                            </ul>
                            <a href="{{ route('payment.index') }}" class="btn btn-dark rounded-pill py-2 btn-block">commander</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="col-md-12">
    <div class="alert alert-warning text-center" role="alert">
        <strong>Votre panier est vide.</strong>
    </div>
</div>
@endif

@endsection

@section('extra-js')
<script>
   document.addEventListener('DOMContentLoaded', function() {
    var selects = document.querySelectorAll('select[name="qty"]');

    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            var rowId = this.dataset.rowId;
            var stock = this.dataset.stock;
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (parseInt(this.value) > parseInt(stock)) {
                alert('La quantité sélectionnée dépasse le stock disponible.');
                this.value = stock;  // Réinitialiser à la quantité maximum disponible
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('PATCH', '/bag/' + rowId);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Mettre à jour les prix affichés
                        document.querySelector(`td[data-row-id="${rowId}"] .subtotal`).textContent = response.subtotal;
                        document.querySelector('.total').textContent = response.total;
                    } else {
                        console.error(response.error);
                    }
                } else {
                    console.error(xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            var data = JSON.stringify({ qty: this.value });
            xhr.send(data);
        });
    });
});

</script>
@endsection

