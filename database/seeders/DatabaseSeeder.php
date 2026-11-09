<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'user']);
        $this->call([
            CategorySeeder::class,
        ]);
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), 
                'role' => 'admin',
            ]
        );
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}