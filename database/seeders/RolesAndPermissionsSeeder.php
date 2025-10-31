<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        
        //  Permissions list based on your endpoints
        $permissions = [
            // Auth
            'register user',
            'login user',
            'logout user',

            // Courses (enseignant)
            'create course',
            'view courses',
            'view course details',
            'update course',
            'delete course',

            // Courses (étudiant)
            'enroll course',
            'view my courses',

            // Users (admin)
            'list users',
            'create user',
            'update user',
            'delete user',
        ];

        //  Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //  Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'enseignant']);
        $studentRole = Role::firstOrCreate(['name' => 'etudiant']);

        // 🛡 Assign permissions by role
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole->givePermissionTo([
            'create course',
            'view courses',
            'view course details',
            'update course',
            'delete course',
        ]);

        $studentRole->givePermissionTo([
            'enroll course',
            'view my courses',
            'view courses',
            'view course details',
        ]);
    }
}
