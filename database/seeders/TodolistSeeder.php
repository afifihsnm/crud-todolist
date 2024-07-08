<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todolist;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::create([
            'user_id' => 1,
            'name' => 'Todo 1',
            'description' => 'Ini adalah todo 1',
            'status' => 0
        ]);
    }
}
