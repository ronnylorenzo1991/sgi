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

//        Permission::create(['name' => 'settings.categories.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.categories.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.categories.edit'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.categories.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.categories.delete'])->syncRoles([$admin, $client]);

//        Permission::create(['name' => 'settings.subcategories.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.subcategories.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.subcategories.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'settings.subcategories.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.subcategories.delete'])->syncRoles([$admin, $client]);

//        Permission::create(['name' => 'settings.internet_links.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.internet_links.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.internet_links.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'settings.internet_links.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.internet_links.delete'])->syncRoles([$admin, $client]);

//        Permission::create(['name' => 'settings.entities.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.entities.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.entities.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'settings.entities.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.entities.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'settings.ministries.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.ministries.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.ministries.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'settings.ministries.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.ministries.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'settings.sites.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.sites.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.sites.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'settings.sites.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.sites.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'security.users.list'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.edit'])->syncRoles([$admin]);
//        Permission::create(['name' => 'security.users.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.users.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'security.roles.list'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.edit'])->syncRoles([$admin]);
//        Permission::create(['name' => 'security.roles.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'security.roles.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'events.events.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'events.events.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'events.events.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'events.events.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'events.events.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'availabilities.availabilities.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'availabilities.availabilities.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'availabilities.availabilities.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'availabilities.availabilities.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'availabilities.availabilities.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'news.news.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'news.news.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'news.news.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'news.news.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'news.news.delete'])->syncRoles([$admin]);

//        Permission::create(['name' => 'reports.reports.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'reports.reports.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'reports.reports.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'reports.reports.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'reports.reports.delete'])->syncRoles([$admin]);
        Permission::create(['name' => 'reports.reports.export'])->syncRoles([$admin]);


//        Permission::create(['name' => 'reports.reports.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.sources.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.sources.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'reports.reports.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.sources.delete'])->syncRoles([$admin]);
        Permission::create(['name' => 'settings.sources.export'])->syncRoles([$admin]);

//        Permission::create(['name' => 'reports.reports.list'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.contributes.create'])->syncRoles([$admin, $client]);
        Permission::create(['name' => 'settings.contributes.edit'])->syncRoles([$admin, $client]);
//        Permission::create(['name' => 'reports.reports.show'])->syncRoles([$admin, $client, $analist]);
        Permission::create(['name' => 'settings.contributes.delete'])->syncRoles([$admin]);
        Permission::create(['name' => 'settings.contributes.export'])->syncRoles([$admin]);

//        Permission::create(['name' => 'settings.teams.list'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.create'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.edit'])->syncRoles([$admin]);
//        Permission::create(['name' => 'settings.teams.show'])->syncRoles([$admin]);
    }
}
