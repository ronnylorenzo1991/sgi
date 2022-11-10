<?php
namespace Database\Seeders;

use App\Models\Users\Entity\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'registrador',
            'email' => 'registrador@sistema.cu',
            'password' => bcrypt('csc-2014')
        ])->assignRole('registrador');
        User::create([
            'name' => 'admin',
            'email' => 'admin@sistema.cu',
            'password' => bcrypt('csc-2014')
        ])->assignRole('admin');
        User::create([
            'name' => 'analista',
            'email' => 'analista@sistema.cu',
            'password' => bcrypt('csc-2014')
        ])->assignRole('analista');
    }
}
