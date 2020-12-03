<?php

use App\Publicacion;
use App\User;
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
      
        $this->call(UserSeeder::class);
        $this->call(PublicacionSeeder::class);
        $this->call(ComentarioSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
