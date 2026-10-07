<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::updateOrCreate(
            ['name' => 'Laptop ASUS'],
            [
                'price' => 7500000,
                'stock' => 10,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Laptop Lenovo'],
            [
                'price' => 6800000,
                'stock' => 8,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Mouse Logitech'],
            [
                'price' => 250000,
                'stock' => 20,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Keyboard Mechanical'],
            [
                'price' => 650000,
                'stock' => 15,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Monitor LG 24 Inch'],
            [
                'price' => 2100000,
                'stock' => 7,
            ]
        );
    }
}