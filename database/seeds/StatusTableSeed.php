<?php

use Illuminate\Database\Seeder;

class StatusTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert(
            [
                ['status' => 'Приета'],
                ['status' => 'В процес'],
                ['status' => 'Приключена'],
                ['status' => 'Взета']
            ]
        );
    }
}
