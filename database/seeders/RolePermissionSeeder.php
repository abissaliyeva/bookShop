<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder {
    public function run(): void {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view books']);
        Permission::create(['name' => 'buy books']);
        Permission::create(['name' => 'manage books']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'ban users']);
        
        
        $guest = Role::create(['name' => 'moderator']);
        $guest->givePermissionTo('view books', 'manage users', 'ban users');

        $student = Role::create(['name' => 'customer']);
        $student->givePermissionTo(['view books', 'buy books']);

        $instructor = Role::create(['name' => 'manager']);
        $instructor->givePermissionTo(['view books', 'manage books', 'manage orders']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        
        $adminUser = User::create([
            'name'    => 'admin',
            'email'    => 'admin@bookShop.com',
            'password' => Hash::make('admin123'),
        ]);
        $adminUser->assignRole('admin');
    }
}