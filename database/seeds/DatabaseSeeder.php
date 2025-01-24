<?php

use App\Client;
use App\Journal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClientSeeder::class);
        $this->call(BookingSeeder::class);

        $clients = Client::orderBy('created_at', 'asc')->take(10)->get();

        foreach ($clients as $client) {
            $numberOfJournals = rand(0, 30);

            factory(Journal::class, $numberOfJournals)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}
