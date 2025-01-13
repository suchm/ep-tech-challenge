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
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        return Client::create($data);
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        if ($client->delete()) {
            return response()->json(['message' => 'Client deleted successfully'], 200);
        }

        return response()->json(['error' => 'Failed to delete client'], 500);
    }
}
