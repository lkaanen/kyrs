<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = "admin";
        $librarian = "librarian";
        $reader = "reader";

        Role::create(["name" => $admin]);
        Role::create(["name" => $librarian]);
        Role::create(["name" => $reader]);
    }
}
