<?php
namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder {
    public function run() : void {
        // firstOrCreate, not updateOrCreate - re-running this seeder must never reset a
        // password that has already been set, for either account.
        User::firstOrCreate(
            [ 'email' => 'romain@reaklab.com' ],
            [ 'name' => 'Romain Carlier', 'password' => bcrypt( str()->random( 32 ) ) ]
        );

        User::firstOrCreate(
            [ 'email' => 'dev@reaklab.com' ],
            [ 'name' => 'Dev', 'password' => bcrypt( 'password' ) ]
        );
    }
}
