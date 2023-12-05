<?php

namespace Database\Seeders;

use App\Models\Operation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Booking time'
            ],
            [
                'name' => 'Booking edit time'
            ],
            [
                'name' => 'Booking cancel time'
            ],
            [
                'name' => 'Login time'
            ]
        ];

        Operation::insert($data);
    }
}
