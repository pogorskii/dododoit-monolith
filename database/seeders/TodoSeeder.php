<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');

        $todosToCreate = [];

        foreach ($userIds as $userId) {
            for ($i = 0; $i < 20; $i++) {
                $todosToCreate[] = Todo::factory()->raw(['user_id' => $userId]);
            }
        }

        Collection::make($todosToCreate)->chunk(1000)->each(function ($chunk) {
            Todo::insert($chunk->toArray());
        });
    }
}
