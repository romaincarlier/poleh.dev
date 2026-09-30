<?php
namespace Database\Seeders;

use Modules\PoleH\Core\Database\Seeders\PolehCoreSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() : void {
        $this->call( [
            AdminUserSeeder::class,
            PolehCoreSeeder::class
        ] );
    }
}
