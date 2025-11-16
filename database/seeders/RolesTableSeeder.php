<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // site actions
        // show all users
        // show all examples
        // show all categories
        // show all blogs

        // edit all user
        // edit all example
        // edit all category
        // edit all blog

        // delete all user
        // delete all example
        // delete all category
        // delete all blog

        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'standard']);
    }
}
