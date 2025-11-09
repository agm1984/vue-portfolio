<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_count = 10;

        User::factory($user_count)->create();

        // Create a specific user
        $adam = User::factory()->create([
            'status' => User::STATUS_ACTIVE, // adjust if your app uses a different field/value
            'name' => 'Adam Mackintosh',
            'email' => 'agm1984@gmail.com',
            'email_verified_at' => now(),
        ]);

        $adam->assignRole('admin');
    }
}
