<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrintType;
use Carbon\Carbon;

class PrintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrintType::insert([
            [
                'name' => 'BASIC',
                'price' => 110000,
                'description' => 'Design baju Jersey non-printing, Number nameset logo polyflex, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'HALF PRINTING',
                'price' => 135000,
                'description' => 'Design baju Jersey printing depan belakang, Number nameset logo printing, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'FULL PRINTING',
                'price' => 150000,
                'description' => 'Design baju Jersey full printing depan belakang, Number nameset logo printing, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'EXCLUSIVE',
                'price' => 170000,
                'description' => 'Design baju Jersey full printing depan belakang, Number nameset logo polyflex, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
