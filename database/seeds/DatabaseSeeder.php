<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypesTableSeed::class);
        $this->call(StatusTableSeed::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(RealTimeService::class);
    }
}
