<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'password' => Hash::make(
                env('ADMIN_PASSWORD')
            ),
            'email' => env('ADMIN_LOGIN'),
        ];
        $user = User::find(1);
        if (!$user) {
            $user = User::create($data);

            foreach (Role::all() as $role) {
                $user->roles()->attach($role);
            }
        } else {
            $user->update($data);

            $user->roles()->detach();
            foreach (Role::all() as $role) {
                $user->roles()->attach($role);
            }
        }
    }
}
