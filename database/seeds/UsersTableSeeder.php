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
            'email' => 'felipe_machado09@hotmail.com',
            'password' => bcrypt('fe@9231805')
        ]);
    }
}
