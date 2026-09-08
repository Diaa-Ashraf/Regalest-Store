<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct ()
    {
        $this->middleware(['permission:create_customers'], ['only' => ['store','create']]);
        $this->middleware(['permission:edit_customers'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:show_customers'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:delete_customers'], ['only' => ['delete']]);
    } 
 
    public function index(Request $request)
    {
        $clients = Client::paginate(10);
        //$clients = Client::all();
        return view('admin.clients.index',compact('clients'));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('admin.clients.create',compact('clients'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated());
        return redirect()->route('clients.index')->with('success',__('add_client successfuly'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit',compact('client'));
    }

 
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return redirect()->route('clients.index')->with('success','delete client successfully');

    }

  
    public function destroy(Client $client)
    {
  
        $client->delete();
        return redirect()->route('clients.index')->with('success','delete client successfully');
        
    }
}
