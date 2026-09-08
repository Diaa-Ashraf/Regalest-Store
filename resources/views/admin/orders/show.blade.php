@extends('layouts.admin')

@section('title')
    {{ __('Order #') . $order->id }}
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">{{ __('Order #') . $order->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>{{ __('Client') }}:</strong> {{ $order->client->name ?? __('N/A') }}</p>
                    <p><strong>{{ __('User') }}:</strong> {{ $order->user->name ?? __('N/A') }}</p>
                    <p><strong>{{ __('User') }}:</strong> {{ $order->user->email ?? __('N/A') }}</p>
                    <p><strong>{{ __('Address') }}:</strong> {{ $order->address }}</p>
                    <p><strong>{{ __('Phone') }}:</strong> {{ $order->phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{ __('Total Price') }}:</strong> {{ number_format($order->total_price, 2) }} {{ __('EGP') }}</p>
                    <p><strong>{{ __('Status') }}:</strong> 
                        <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                            {{ __($order->status) }}
                        </span>
                    </p>
                    <p><strong>{{ __('Payment Method') }}:</strong> {{ __($order->payment_method) }}</p>
                </div>
            </div>

            <h4 class="mt-4">{{ __('Products') }}</h4>
            @if($order->orderItems->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? __('N/A') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }} {{ __('EGP') }}</td>
                                    <td>{{ number_format($item->price * $item->quantity, 2) }} {{ __('EGP') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">{{ __('No products in this order') }}</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('Back to Orders') }}</a>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">{{ __('Edit Order') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection