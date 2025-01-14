<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use App\Http\Requests\JournalRequest;
use App\Repositories\JournalRepository;

class JournalController extends Controller
{
    protected $journalRepository;

    public function __construct(JournalRepository $journalRepository)
    {
        $this->journalRepository = $journalRepository;
    }

    public function index(Client $client)
    {
        $this->authorize('view', $client);

        $journals = $this->journalRepository->getAllJournalsForClient($client);

        return response()->json($journals);
    }

    public function store(JournalRequest $request, Client $client)
    {
        $this->authorize('create', [Journal::class, $client]);

        $data = $request->validated();

        $journal = $this->journalRepository->createJournal($client, $data);

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

        if ($this->journalRepository->deleteJournal($journal)) {
            return response()->json(['message' => 'Journal deleted successfully'], 200);
        }

        return response()->json(['error' => 'Failed to delete journal'], 500);
    }
}

