@extends('layouts.admin')

@section('title')
    {{ __('stock_details') }}
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4>{{ __('stock_details') }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('stock_name') }}</th>
                    <td>{{ $stock->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('stock_code') }}</th>
                    <td>{{ $stock->code }}</td>
                </tr>
                <tr>
                    <th>{{ __('stock_price') }}</th>
                    <td>{{ number_format($stock->price, 2) }}</td>
                </tr>
                <tr>
                    <th>{{ __('stock_quantity') }}</th>
                    <td>{{ $stock->quantity }}</td>
                </tr>
                <tr>
                    <th>{{ __('created_at') }}</th>
                    <td>{{ $stock->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>{{ __('updated_at') }}</th>
                    <td>{{ $stock->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>

            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning">{{ __('buttons_edit') }}</a>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">{{ __('buttons_back') }}</a>
        </div>
    </div>

@endsection