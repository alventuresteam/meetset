<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\Operation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logData = [];

        for ($i = 1; $i <= 30; $i++) {
            $logData[] = [
                'user_id' => User::all()->pluck('id')->random(),
                'operation_id' => Operation::all()->pluck('id')->random(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }

        Log::insert($logData);
    }
}
