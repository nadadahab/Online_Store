<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Nada Dahab', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'is_admin' => true]);    
    }
}
