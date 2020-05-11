<?php

use App\User;
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

        factory(User::class, $user_count)->create();

        $adam = factory(User::class, 1)->create([
            'status' => User::STATUS_ACTIVE,
            'name' => 'Adam Mackintosh',
            'email' => 'agm1984@gmail.com',
            'email_verified_at' => now(),
        ])->first();

        $adam->assignRole('admin');
    }
}
