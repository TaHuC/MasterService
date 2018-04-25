<?php

use Illuminate\Database\Seeder;

class RealTimeService extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('real_time_services')->insert(
            [
                'service' => 'task',
                'check' => false
            ]
        );
    }
}
