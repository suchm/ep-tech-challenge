<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Client;
use App\Repositories\ClientRepository;

class ClientController extends Controller
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
        $clients = $this->clientRepository->getAllClientsWithBookingCount(auth()->id());

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $client = $this->clientRepository->findClientWithBookings($client->id);

        return view('clients.show', ['client' => $client]);
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $client = $this->clientRepository->createClient($data);

        return $client;
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        if ($this->clientRepository->deleteClient($client)) {
            return response()->json(['message' => 'Client deleted successfully'], 200);
        }

        return response()->json(['error' => 'Failed to delete client'], 500);
    }
}
