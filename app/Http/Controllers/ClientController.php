<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('bookings')
            ->where('user_id', auth()->id())
            ->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $client->load('bookings');

        return view('clients.show', ['client' => $client]);
    }

    public function store(ClientRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $client = Client::create($validated);

        return $client;
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return 'Deleted';
    }
}
