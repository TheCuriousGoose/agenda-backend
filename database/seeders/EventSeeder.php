<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use DateInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        for ($i = 0; $i < 30; $i++) {
            $startDate = $faker->dateTimeBetween('now', '+2 months');
            $endDate = clone $startDate;
            $endDate->add(new DateInterval('PT2H'));

            $event = Event::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $event->users()->attach($users->random()->id);
            }
        }
    }
}
