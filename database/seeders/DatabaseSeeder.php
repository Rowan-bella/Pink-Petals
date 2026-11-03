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

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles များကို Spatie ဖြင့် ကြိုတင်ဖန်တီးခြင်း
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'user']);

        // 2. Category များကို Seeder မှတစ်ဆင့် ထည့်သွင်းခြင်း (👈 ဒီနေရာကို ထည့်ပါ)
        $this->call([
            CategorySeeder::class,
        ]);

        // 3. Admin User အား Duplicate မဖြစ်စေရန် firstOrCreate သုံးခြင်း
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // ဒီ email ရှိမရှိ စစ်မယ်
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // လိုအပ်မယ့် password ထည့်ပါ
                'role' => 'admin',
            ]
        );

        // 4. Spatie Role ထည့်ပေးခြင်း
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}