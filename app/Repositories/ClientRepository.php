<?php
namespace App\Repositories;

use App\Client;

class ClientRepository
{
    public function getAllClientsWithBookingCount($userId)
    {
        return Client::withCount('bookings')
            ->where('user_id', $userId)
            ->get();
    }

    public function findClientWithBookings($clientId)
    {
        return Client::with('bookings')->findOrFail($clientId);
    }

    public function createClient(array $data)
    {
        return Client::create($data);
    }

    public function deleteClient(Client $client)
    {
        return $client->delete();
    }
}
