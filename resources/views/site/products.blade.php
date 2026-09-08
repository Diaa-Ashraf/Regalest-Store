@extends('layouts.site')

@section('content')
    <h2 class="text-center mb-4">{{ __('Products') }}</h2>

    @if ($products->isEmpty())
        <p class="text-center text-muted">{{ __('No products found.') }}</p>
    @else
        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach ($products as $product)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover; border-top-left-radius: 0.375rem; border-top-right-radius: 0.375rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                <p class="fw-bold">${{ $product->price }}</p>
                                <a href="{{ route('product.details', $product->id) }}" class="btn btn-primary btn-sm mt-2">{{ __('View') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    @endif
@endsection
