@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>{{ __('Create Order') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('User') }}</label>
            <input type="text" name="user_name" class="form-control" value="{{ auth()->user()->name }}" readonly>
            <!-- حقل مخفي لإرسال user_id -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            @error('user_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

            <div class="col-md-6">
                <label class="form-label">{{ __('Client') }}</label>
                <select name="client_id" class="form-control" required>
                    <option value="">{{ __('Select Client') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->email }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Address') }}</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">{{ __('Phone') }}</label>
                <input type="text" name="phone" class="form-control" required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ __('Payment Method') }}</label>
                <select name="payment_method" class="form-control" required>
                    <option value="">{{ __('Select Payment Method') }}</option>
                    <option value="cash">{{ __('Cash') }}</option>
                    <option value="credit">{{ __('Credit') }}</option>
                </select>
                @error('payment_method')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Status') }}</label>
            <select name="status" class="form-control" required>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="completed">{{ __('Completed') }}</option>
                <option value="cancelled">{{ __('Cancelled') }}</option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

       <div id="products" class="mb-3">
    <h5>{{ __('Products') }}</h5>
    <div class="product-row mb-2" data-index="0">
        <div class="row align-items-center">
            <div class="col-md-6">
                <select name="products[0][product_id]" class="form-control" required>
                    <option value="">{{ __('Select Product') }}</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="products[0][quantity]" class="form-control" placeholder="{{ __('Quantity') }}" min="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-row">{{ __('Remove') }}</button>
            </div>
        </div>
    </div>
</div>

<button type="button" id="add-product" class="btn btn-secondary mb-3">{{ __('Add Product') }}</button>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
            </div>
    </form>
</div>

<script>
    document.getElementById('add-product').addEventListener('click', function() {
        let productRows = document.querySelectorAll('.product-row');
        let newIndex = productRows.length; // الفهرس الجديد بناءً على عدد الصفوف
        let productRow = document.querySelector('.product-row').cloneNode(true);

        // تعديل الـ name بتاع الـ select والـ input بالفهرس الجديد
        productRow.querySelector('select').name = `products[${newIndex}][product_id]`;
        productRow.querySelector('input').name = `products[${newIndex}][quantity]`;
        productRow.querySelector('input').value = ''; // Reset quantity
        productRow.querySelector('select').selectedIndex = 0; // Reset product

        document.getElementById('products').appendChild(productRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            let rows = document.querySelectorAll('.product-row');
            if (rows.length > 1) { // Keep at least one row
                e.target.closest('.product-row').remove();
            }
        }
    });
</script>
@endsection