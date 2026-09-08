@extends('layouts.admin')



@section('content')
    <div class="container">
        <h2>{{ __('update client') }}</h2>
        <form action="{{ route('clients.update',$client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$client->name) }}" required>
                <label for="name" class="form-label">{{ __('name') }}</label>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">{{ __('phone') }}</label>
                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$client->phone) }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="mb-3">
                <label for="email" class="form-label"> {{ __('email') }}</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$client->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('password') }}</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">{{ __('address') }}</label>
                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address',$client->address) }}" required>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>




            <button type="submit" class="btn btn-primary">{{ __('update client') }}</button>

        </form>
    </div>
@endsection
