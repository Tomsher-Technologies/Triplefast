<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
$user = User::create([
'name' => 'Jisha',
'email' => 'admin@yopmail.com',
'password' => bcrypt('123456')
]);
$role = Role::create(['name' => 'Admin','type' => 2]);
$permissions = Permission::pluck('id','id')->all();
$role->syncPermissions($permissions);
setPermissionsTeamId(2);
$user->assignRole([$role->id]);
}
}
