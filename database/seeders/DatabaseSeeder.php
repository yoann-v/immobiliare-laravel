<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\User::factory(5)->unverified()->create();

        //Property::factory(100)->create();

        $properties = ['Maison', 'Appartement', 'Garage', 'T3', 'Terrasse'];

        foreach ($properties as $property)
        Property::factory()->create([
            'title' => $property,
            'user_id' => User::all()->random()
        ]);


        /*DB::table('properties')->insert([
            'title' => $property,
            'description' => 'Une super annonce pour '.$property,
            'price' => rand(25000, 150000),
            'sold' => rand(0, 1),
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);*/
    }
}
