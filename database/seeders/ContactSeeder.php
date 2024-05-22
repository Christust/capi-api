<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Faker\Factory as Faker;


class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Faker::create();

        foreach (range(1, 5000) as $index) {
            $contact = Contact::create([
                'name' => $faker->name,
            ]);

            foreach (range(1, mt_rand(1, 3)) as $i) {
                Phone::create([
                    'contact_id' => $contact->id,
                    'phone_number' => $faker->phoneNumber,
                ]);
            }

            foreach (range(1, mt_rand(1, 3)) as $i) {
                Email::create([
                    'contact_id' => $contact->id,
                    'email' => $faker->email,
                ]);
            }

            foreach (range(1, mt_rand(1, 2)) as $i) {
                Address::create([
                    'contact_id' => $contact->id,
                    'address' => $faker->address,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'country' => $faker->country,
                    'postal_code' => $faker->postcode,
                ]);
            }
        }
    }
}
