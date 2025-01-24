<?php
namespace App\Repositories;

use App\Journal;

class JournalRepository
{
    public function getAllJournalsForClient($client)
    {
        return $client->journals()->latest()->get();
    }

    public function createJournal($client, array $data)
    {
        return Journal::create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'body' => $data['body'],
        ]);
    }

    public function findJournal($journalId)
    {
        return Journal::findOrFail($journalId);
    }

    public function deleteJournal($journal)
    {
        return $journal->delete();
    }
}
