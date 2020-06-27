<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id'   => 1,
                'name' => 'Processing',
            ],
            [
                'id'   => 2,
                'name' => 'Analyst processing',
            ],
            [
                'id'   => 3,
                'name' => 'Analyst approved',
            ],
            [
                'id'   => 4,
                'name' => 'Analyst rejected',
            ],
            [
                'id'   => 5,
                'name' => 'CFO processing',
            ],
            [
                'id'   => 6,
                'name' => 'CFO approved',
            ],
            [
                'id'   => 7,
                'name' => 'CFO rejected',
            ],
            [
                'id'   => 8,
                'name' => 'Approved',
            ],
            [
                'id'   => 9,
                'name' => 'Rejected',
            ],
        ];

        Status::insert($statuses);
    }
}
