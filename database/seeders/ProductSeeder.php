<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create products
        $products = [
            [
                'name' => 'Spanduk / Baliho',
                'description' => 'Cetak spanduk dan baliho berkualitas tinggi dengan berbagai ukuran sesuai kebutuhan Anda.',
                'price' => 25000, // Price per meter
                'images' => [
                    [
                        'path' => 'products/spanduk-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/spanduk-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'name' => 'Papan Bunga Printing Standart',
                'description' => 'Papan bunga printing ukuran standart untuk berbagai acara seperti pernikahan, ulang tahun, dan lainnya.',
                'price' => 150000,
                'images' => [
                    [
                        'path' => 'products/papan-bunga-standart-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/papan-bunga-standart-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'name' => 'Papan Bunga Printing Jumbo',
                'description' => 'Papan bunga printing ukuran jumbo untuk berbagai acara besar dan formal. Tampil lebih megah dan menarik.',
                'price' => 250000,
                'images' => [
                    [
                        'path' => 'products/papan-bunga-jumbo-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/papan-bunga-jumbo-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'name' => 'X Banner + Rangka',
                'description' => 'X Banner lengkap dengan rangka, ideal untuk promosi di pameran, event, dan di depan toko.',
                'price' => 175000,
                'images' => [
                    [
                        'path' => 'products/x-banner-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/x-banner-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'name' => 'Umbul-umbul',
                'description' => 'Umbul-umbul dengan desain menarik untuk berbagai kebutuhan dekorasi dan promosi outdoor.',
                'price' => 75000, // Price per meter
                'images' => [
                    [
                        'path' => 'products/umbul-umbul-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/umbul-umbul-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'name' => 'Stiker (Branding)',
                'description' => 'Stiker untuk kebutuhan branding dengan kualitas cetak premium dan tahan lama.',
                'price' => 100000, // Price per meter
                'images' => [
                    [
                        'path' => 'products/stiker-1.jpg',
                        'is_primary' => true,
                    ],
                    [
                        'path' => 'products/stiker-2.jpg',
                        'is_primary' => false,
                    ]
                ]
            ],
        ];

        foreach ($products as $productData) {
            $images = $productData['images'];
            unset($productData['images']);
            
            // Create the product
            $product = Product::create($productData);
            
            // Create associated images
            foreach ($images as $imageData) {
                $product->images()->create($imageData);
            }
    }
}
}
