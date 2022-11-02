<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $analist = Role::create(['name' => 'analista']);
        $client = Role::create(['name' => 'registrador']);

        Permission::create(['name' => 'dashboard.charts.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'audits.audits.list'])->syncRoles([$admin]);

        Permission::create(['name' => 'settings.categories.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.categories.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.categories.edit'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.categories.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.categories.delete'])->syncRoles([$admin, $client]);

        Permission::create(['name' => 'settings.subcategories.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.subcategories.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.subcategories.edit'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.subcategories.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.subcategories.delete'])->syncRoles([$admin, $client]);

        Permission::create(['name' => 'security.users.list'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.delete'])->syncRoles([$admin]);

        Permission::create(['name' => 'security.roles.list'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.delete'])->syncRoles([$admin]);

        Permission::create(['name' => 'events.events.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'events.events.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'events.events.edit'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'events.events.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'events.events.delete'])->syncRoles([$admin]);

        Permission::create(['name' => 'settings.entities.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.entities.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.entities.edit'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.entities.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.entities.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'settings.teams.list'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.create'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.edit'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.show'])->syncRoles([$admin]);
    }
}
