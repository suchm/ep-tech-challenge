<?php

namespace App\Policies;

use App\Client;
use App\Journal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    /**
     * Determine whether the user can view any journals for the given client.
     *
     * @param  \App\User  $user
     * @param  \App\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Client  $client
     * @param  \App\Journal  $journal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Client $client, Journal $journal): bool
    {
        return $user->id === $client->user_id && $journal->client_id === $client->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Client  $client
     * @param  \App\Journal  $journal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Client $client, Journal $journal): bool
    {
        return $user->id === $client->user_id && $journal->client_id === $client->id;
    }
}
