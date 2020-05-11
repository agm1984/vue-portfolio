<?php

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
        $role->givePermissionTo(Permission::create(['name' => 'edit users']));
        $role->givePermissionTo(Permission::create(['name' => 'edit examples']));
        $role->givePermissionTo(Permission::create(['name' => 'edit categories']));
        $role->givePermissionTo(Permission::create(['name' => 'edit blogs']));

    }
}
