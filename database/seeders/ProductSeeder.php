<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                "id" => 1,
                "name" => "KAMBING",
                "summary" => "KAMBIH QURBAN",
                "description" => "hallo guys welcome di ufang ungan hiya, hallo guys welcome di ufang ungan hiya, hallo guys welcome di ufang ungan hiya,hallo guys welcome di ufang ungan hiya",


            ],
            [
                "id" => 2,
                "name" => "AKIQAH",
                "summary" => "AQIQAH",
                "description" => "hallo guys welcome di ufang ungan hiya, hallo guys welcome di ufang ungan hiya, hallo guys welcome di ufang ungan hiya,hallo guys welcome di ufang ungan hiya",


            ],
        ]);

        ProductDetail::insert([
            [
                "id" => 1,
                "product_id" => 1,
                "image" => "/storage/images/profile/629c359a857ef.jpg",
                "name" => "GRADE A",
                "detail" => "SIZE 21-25 KG",
                "price" => 2000000.0,
                "stock" => 20,


            ],
            [
                "id" => 2,
                "product_id" => 1,
                "image" => "/storage/images/profile/629c359a857ef.jpg",
                "name" => "GRADE B",
                "detail" => "SIZE 26-30 KG",
                "price" => 2500000.0,
                "stock" => 10,


            ],
            [
                "id" => 3,
                "product_id" => 1,
                "image" => "/storage/images/profile/629c359a857ef.jpg",
                "name" => "GRADE C",
                "detail" => "SIZE 31-35 KG",
                "price" => 3000000.0,
                "stock" => 15,


            ],
            [
                "id" => 4,
                "product_id" => 1,
                "image" => "/storage/images/profile/629c359a857ef.jpg",
                "name" => "GRADE D",
                "detail" => "SIZE 36-40 KG",
                "price" => 4000000.0,
                "stock" => 10,


            ],
            [
                "id" => 5,
                "product_id" => 2,
                "image" => "/storage/images/profile/629c35c4cfb4d.jpg",
                "name" => "PAKET A",
                "detail" => "300 - 350 TUSUK",
                "price" => 2500000.0,
                "stock" => 10,


            ],
            [
                "id" => 6,
                "product_id" => 2,
                "image" => "/storage/images/profile/629c35c4cfb4d.jpg",
                "name" => "PAKET B",
                "detail" => "400 - 450 TUSUK",
                "price" => 2800000.0,
                "stock" => 5,


            ],
            [
                "id" => 7,
                "product_id" => 2,
                "image" => "/storage/images/profile/629c35c4cfb4d.jpg",
                "name" => "PAKET C",
                "detail" => "500 - 550 TUSUK",
                "price" => 3000000.0,
                "stock" => 10,

            ],
        ]);
    }
}
