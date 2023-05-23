<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Offline seeders (DO NOT RUN ONLINE)
        $this->call(OfflineUsersSeeder::class);
        $this->call(MedicationSeeder::class);
        $this->call(TestSeeder::class);





        // Online seeders (RUN ONLY ONCE)
        // $this->call(MedicationSeeder::class); - Ran on 07/04/2021
        // $this->call(AdminSeeder01::class); - Ran on 07/04/2021
    }
}
