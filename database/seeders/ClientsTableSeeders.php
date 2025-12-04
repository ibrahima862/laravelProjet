<?php

namespace Database\Seeders;

use App\Models\client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ClientsTableSeeders extends Seeder
{
    public function run(): void
    {
        Client::factory()->count(50)->create();
}
}