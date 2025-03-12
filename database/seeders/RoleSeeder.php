<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $admin = Role::create(['name' => 'Admin']);
        $employer = Role::create(['name' => 'Employer']);
        $candidate = Role::create(['name' => 'Candidate']);

        $permissions = [
            'manage users', 
            'post job', 
            'apply job', 
            'manage applications', 
            'view all jobs'
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $admin->givePermissionTo([
            'manage users', 
            'post job', 
            'manage applications', 
            'view all jobs'
        ]);
        
        $employer->givePermissionTo([
            'post job', 
            'manage applications'
        ]);

        $candidate->givePermissionTo([
            'apply job'
        ]);
    }
}
