<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(VoyagerDummyDatabaseSeeder::class);
    }
}
