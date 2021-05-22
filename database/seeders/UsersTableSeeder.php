<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(Article::factory(250))
            ->create([
                'name' => 'Moeen Basra',
                'email' => 'pablo@alphacodesoftware.com',
                'password' => bcrypt('123456'),
                'is_admin' => true,
                'remember_token' => Str::random(10),
            ]);

        User::factory(50)->create();
    }
}
