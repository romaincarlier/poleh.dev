<?php
namespace Database\Seeders;

use Modules\Pole\Core\Database\Seeders\PoleCoreSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() : void {
        $this->call( [
            AdminUserSeeder::class,
            PoleCoreSeeder::class
        ] );
    }
}
