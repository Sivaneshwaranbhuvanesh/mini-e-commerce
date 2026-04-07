<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name'=>'Admin User','email'=>'admin@shop.com','password'=>Hash::make('password'),'role'=>'admin']);
        User::create(['name'=>'John User','email'=>'user@shop.com','password'=>Hash::make('password'),'role'=>'user']);

        $categories = ['Electronics','Clothing','Books','Home & Garden','Sports'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        $products = [
            ['name'=>'Wireless Headphones','price'=>2999,'description'=>'Premium sound quality wireless headphones with noise cancellation.','category_id'=>1,'stock'=>25],
            ['name'=>'Smartphone Pro','price'=>49999,'description'=>'Latest smartphone with triple camera system.','category_id'=>1,'stock'=>15],
            ['name'=>'Laptop Ultra','price'=>79999,'description'=>'Thin and light laptop for professionals.','category_id'=>1,'stock'=>10],
            ['name'=>'Cotton T-Shirt','price'=>499,'description'=>'Comfortable everyday cotton t-shirt.','category_id'=>2,'stock'=>100],
            ['name'=>'Denim Jeans','price'=>1299,'description'=>'Classic fit denim jeans for all occasions.','category_id'=>2,'stock'=>50],
            ['name'=>'Laravel Mastery','price'=>799,'description'=>'Complete guide to Laravel development.','category_id'=>3,'stock'=>30],
            ['name'=>'PHP Cookbook','price'=>599,'description'=>'Recipes for PHP solutions.','category_id'=>3,'stock'=>20],
            ['name'=>'Garden Hose Set','price'=>899,'description'=>'Expandable garden hose with spray nozzle.','category_id'=>4,'stock'=>35],
            ['name'=>'Yoga Mat','price'=>699,'description'=>'Non-slip premium yoga mat for all types of yoga.','category_id'=>5,'stock'=>40],
            ['name'=>'Running Shoes','price'=>3499,'description'=>'Lightweight running shoes for marathon training.','category_id'=>5,'stock'=>20],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}