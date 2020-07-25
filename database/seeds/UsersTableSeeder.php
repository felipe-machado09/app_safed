<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->create([
            'email' => 'felipewin48@gmail.com',
            'password' => bcrypt('fe@9231805')
        ]);
        factory(\App\Models\User::class)->create([
            'email' => 'gabriel@email.com',
            'password' => bcrypt('gabriel123')
        ]);
    }
}
