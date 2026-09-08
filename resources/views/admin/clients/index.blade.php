@extends('layouts.admin')

@section('title')

@endsection


@section('content')

  <h3 class="box-title" style="margin-bottom: 15px">{{ __('clients') }} <small>{{ $clients->total() }}</small></h3>


<a href="{{ route('clients.create') }}" class="btn btn-primary">{{ __('create_clients') }}</a>

<div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">

      <tr>
        <th scope="col">#</th>
        <th scope="col">{{ __('client-name') }}</th>
        <th scope="col">{{ __('client-email') }}</th>
        <th scope="col">{{ __('client-address') }}</th>
        <th scope="col">{{ __('client-phone') }}</th>
        <th scope="col">{{ __('actions') }}</th>



      </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
          <tr>
            <th>{{$loop->index + 1 }}</th>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->phone }}</td>
            <td>
                <a href="{{route('clients.edit',$client->id)}}" class="btn btn-sm btn-outline-warning">{{__('buttons_edit')}}</a>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">{{__('buttons_delete')}}</button>
                </form>
                </td>


          </tr>
        @endforeach
          </tbody>
  </table>
</div>
</div>

@endsection




