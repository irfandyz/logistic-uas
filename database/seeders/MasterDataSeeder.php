<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Supplier;


class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Category::create([
                'name' => 'Category ' . $i,
            ]);
            Customer::create([
                'name' => 'Customer ' . $i,
                'phone' => '081234567890' . $i,
                'email' => 'customer' . $i . '@gmail.com',
                'address' => 'Address ' . $i,
            ]);
            Supplier::create([
                'name' => 'Supplier ' . $i,
                'phone' => '081234567890' . $i,
                'email' => 'supplier' . $i . '@gmail.com',
                'address' => 'Address ' . $i,
            ]);
            Shipping::create([
                'name' => 'Shipping ' . $i,
                'person_in_charge' => 'Person In Charge ' . $i,
                'transportation' => 'Transportation ' . $i,
                'description' => 'Description ' . $i,
            ]);
        }
    }
}
