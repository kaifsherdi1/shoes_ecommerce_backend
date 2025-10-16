<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
        ]);

        // Random users
        User::factory(5)->create();

        // Brands
        $brands = collect(['Nike','Adidas','Puma'])->map(fn($name) => Brand::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]));

        // Category
        $cat = Category::create(['name' => 'Sneakers', 'slug' => 'sneakers']);

        // Products
        for ($i = 1; $i <= 10; $i++) {
            $p = Product::create([
                'name' => "Sample Shoe $i",
                'slug' => "sample-shoe-$i",
                'description' => 'A sample product',
                'price' => rand(2000,6000),
                'category_id' => $cat->id,
                'brand_id' => $brands->random()->id,
            ]);

            // Product variant
            ProductVariant::create([
                'product_id' => $p->id,
                'sku' => 'SKU'.rand(1000,9999),
                'size' => '9',
                'color' => 'Black',
                'stock' => rand(5,20),
                'price' => $p->price,
            ]);
        }
    }
}
