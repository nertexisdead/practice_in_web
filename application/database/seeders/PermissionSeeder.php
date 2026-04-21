<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('permissions') as $permission => $roles) {
            $permissionInstance = Permission::where('slug', $permission)->first();
            if (!$permissionInstance) {
                $permissionInstance = new Permission([
                    'slug' => $permission,
                    'name' => $permission,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $permissionInstance->save();
            }
            $permissionInstance->roles()->detach();
            foreach ($roles as $role) {
                $permissionInstance->roles()->attach($role);
            }
        }
    }
}
