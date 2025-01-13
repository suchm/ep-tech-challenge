<?php

use App\User;
use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([User::first() ?? factory(User::class)->create()]);
        $users = $users->merge(factory(User::class, 2)->create());

        foreach ($users as $user) {
            factory(Client::class, 100)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
