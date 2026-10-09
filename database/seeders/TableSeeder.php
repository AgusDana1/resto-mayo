<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            ['table_code' => 'M01', 'table_number' => 1, 'status' => 'available'],
            ['table_code' => 'M02', 'table_number' => 2, 'status' => 'available'],
            ['table_code' => 'M03', 'table_number' => 3, 'status' => 'available'],
            ['table_code' => 'M04', 'table_number' => 4, 'status' => 'available'],
            ['table_code' => 'M05', 'table_number' => 5, 'status' => 'available'],
            ['table_code' => 'M06', 'table_number' => 6, 'status' => 'available'],
            ['table_code' => 'M07', 'table_number' => 7, 'status' => 'available'],
            ['table_code' => 'M08', 'table_number' => 8, 'status' => 'available'],
            ['table_code' => 'M09', 'table_number' => 9, 'status' => 'available'],
            ['table_code' => 'M10', 'table_number' => 10, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
