<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\Administrator;

class AdminSeeder01 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Paulo
        $adminUser = User::create([
            'name' => 'adminpm',
            'email' => 'support@vitruvianshield.com',
            'password' => Hash::make('123456Vitruvian'),
            'email_verified_at' => Carbon::now(),
            'type' => User::ADMIN,
        ]);

        $adminData = Administrator::create([
            'fk_user_id' => $adminUser->id,
            'full_name' => "Paulo Martins",
        ]);
    }
}
