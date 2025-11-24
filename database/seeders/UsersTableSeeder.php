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
        // $user_count = 10;

        // User::factory($user_count)->create()->each(function ($user) {
        //     $user->assignRole('standard');
        // });

        // Create root admin
        $adam = User::firstOrCreate(
            ['email' => 'agm1984@gmail.com'], // Look for this email...
            [
                'status' => User::STATUS_ACTIVE,
                'name' => 'Adam Mackintosh',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        );

        if (! $adam->hasRole('admin')) {
            $adam->assignRole('admin');
        }
    }
}
