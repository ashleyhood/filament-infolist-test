<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\ContactLog;
use App\Models\Note;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $referral = Referral::factory()
            ->for(Client::factory())
            ->create([
                'employment_advisor_id' => $user->id,
                'status' => 'Open',
            ]);

        $appointment1 = Appointment::factory()
            ->for($user)
            ->for($referral)
            ->create([
                'status' => 'Attended',
                'start_at' => now()->subDay(),
                'end_at' => now()->subDay()->addHour(),
            ]);

        $appointment2 = Appointment::factory()
            ->for($user)
            ->for($referral)
            ->create([
                'status' => 'Open',
                'start_at' => now()->addDay(),
                'end_at' => now()->addDay()->addHour(),
            ]);

        $contactLog1 = ContactLog::factory()
            ->for($appointment1)
            ->create();

        $contactLog2 = ContactLog::factory()
            ->for($appointment2)
            ->create();

        Note::factory(2)
            ->make()
            ->each(function ($note) use ($contactLog1) {
                $contactLog1->notes()->save($note);
            });

        Note::factory(2)
            ->make()
            ->each(function ($note) use ($contactLog2) {
                $contactLog2->notes()->save($note);
            });
    }
}
