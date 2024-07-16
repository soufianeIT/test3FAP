@extends('layouts.apps')

@section('content')
  @foreach ($products as $product)
    <div class="col-md-6">
      <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
        <div class="card mb-4 box-shadow">
          <div class="row no-gutters">
            <div class="col-md-6 p-4 d-flex flex-column jjustify-content-between">
              <div>
                <!-- <span class="badge badge-success mb-2">Product</span> -->
                <small class="d-inline-block mb-2">
                   @foreach ($product->categories as $category)
                    {{ $category->name }}{{ $loop->last ? '' : ', '}}
                   @endforeach
                </small>
                <h5 class="mb-0">{{ $product->title }}</h5>
                <p class="mb-2 text-muted">{{ $product->subtitle }}</p>
              </div>
              <div>
                <span class="text-secondary">{{ $product->getFormattedPrice() }}</span>
              </div>
            </div>
            <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" alt="">
            </div>
          </div>
        </div>
      </a>
    </div>
  @endforeach
  {{ $products->appends(request()->input())->links('pagination::bootstrap-5') }}

@endsection
