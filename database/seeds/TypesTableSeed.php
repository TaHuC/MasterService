<?php

use Illuminate\Database\Seeder;

class TypesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert(
            [
                ['title' => 'GSM'],
                ['title' => 'Tablet'],
                ['title' => 'Laptop'],
                ['title' => 'PC']
            ]
        );
    }
}
