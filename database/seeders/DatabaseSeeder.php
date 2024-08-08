<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Conversation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(3)->create();
        $conversation12=Conversation::Create();
        $conversation13=Conversation::Create();
        $conversation23=Conversation::Create();

        $conversation12->users()->sync([1,2]);
        $conversation13->users()->sync([1,3]);
        $conversation23->users()->sync([2,3]);
    }
}
