<?php

  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin', 
            'email' => 'admin@triplefast.com',
            'password' => Hash::make('admin@123'),
            'user_type' => 'admin',
        ]);
    
        // $role = Role::create(['name' => 'super_admin','title' => 'Super Admin','type' =>null]);
     
        // $permissions = Permission::pluck('id','id')->all();
   
        // $role->syncPermissions($permissions);
        // setPermissionsTeamId(1);
        // $user->assignRole([$role->id]);
    }
}
