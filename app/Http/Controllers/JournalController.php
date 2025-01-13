<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\JournalRequest;
use App\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{

    public function index(Client $client)
    {
        $this->authorize('view', $client);

        $journals = $client->journals()->latest()->get();

        return response()->json($journals);
    }

    public function store(JournalRequest $request, Client $client)
    {
        $request->validate(['body' => 'required|string',]);

        $journal = Journal::create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'body' => $request->input('body'),
        ]);

        return response()->json($journal, 201);
    }

    public function show(Client $client, Journal $journal)
    {
        $this->authorize('view', [$client, $journal]);

        return response()->json($journal);
    }

    public function destroy(Client $client, Journal $journal)
    {
        $this->authorize('delete', [$client, $journal]);

        $journal->delete();

        return response()->json(['message' => 'Journal deleted successfully.']);
    }
}
