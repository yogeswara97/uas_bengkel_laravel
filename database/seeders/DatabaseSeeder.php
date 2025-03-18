<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Customer::factory(30)->create();

        Customer::factory()->create([
            'first_name' => 'Yoges',
            'last_name' => 'wara',
            'email' => 'yoges@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('yoges'),
            'phone' => '081337304399',
            'gender' => 'male',
            'remember_token' => Str::random(10),
            'dob' => '2004-07-09',
            'bio' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad earum sint, iure perspiciatis aperiam quae at mollitia eveniet voluptatum reprehenderit cum velit nihil corporis unde rem laudantium libero vitae. Veritatis molestiae totam, rem quae fugiat soluta, dolorem ipsa corrupti blanditiis quis sunt nam quisquam officiis quia optio mollitia consequatur deleniti.'
        ]);

        User::factory()->create([
            'name' => 'Yogeswara',
            'email' => 'yogesaja@gmail.com',
            'password' => bcrypt('yogesaja'),
        ]);

        User::factory()->create([
            'name' => 'Pande Fajar',
            'email' => 'pandeaja@gmail.com',
            'password' => bcrypt('pandeaja'),
        ]);

        Category::factory()-> create([
            'name' => 'Vehicle',
            'slug' => 'vehicle'
        ]);
        Category::factory()-> create([
            'name' => 'Charging',
            'slug' => 'charging'
        ]);
    }
}


