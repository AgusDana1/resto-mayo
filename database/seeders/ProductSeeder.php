<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the products table with authentic dishes including Nasi Goreng, Risoles Mayonise, and drinks.
     */
    public function run(): void
    {
        $makanan = Category::firstOrCreate(['name' => 'Makanan']);
        $dimsum = Category::firstOrCreate(['name' => 'Dimsum']);
        $minuman = Category::firstOrCreate(['name' => 'Minuman']);

        $products = [
            [
                'category_id' => $makanan->id,
                'name' => 'Risoles Mayonise Keju Lumer',
                'description' => 'Menu andalan Resto Mayo! Risoles renyah keemasan dengan isian daging asap premium, telur rebus lembut, keju lumer, dan racikan mayonise spesial yang gurih memikat.',
                'price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Nasi Goreng Spesial Resto Mayo',
                'description' => 'Nasi goreng racikan bumbu rempah autentik dengan suwiran ayam gurih, udang segar, telur mata sapi setengah matang, kerupuk udang renyah, dan acar segar.',
                'price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Nasi Goreng Seafood Pedas',
                'description' => 'Nasi goreng kaya aroma dengan paduan udang manis, cumi kenyal, dan bakso ikan disiram sambal terasi gurih dengan tingkat kepedasan pas.',
                'price' => 36000,
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Ayam Bakar',
                'description' => 'Ayam bakar dengan bumbu yang meresap dan membuat kenyang seharian.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Dimsum Ayam Mayo Mentai',
                'description' => 'Siomay ayam gurih lembut isi 4 pcs disajikan hangat dengan baluran saus mentai mayonise bakar yang harum menggugah selera.',
                'price' => 24000,
                'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Udang Keju',
                'description' => 'Udang Keju dengan mozarella yang lumer untuk pelanggan tercinta dari resto mayo',
                'price' => 10000,
                'image' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Udang Mayo',
                'description' => 'Udang Mayo dengan topping mayonise khas milik resto mayo',
                'price' => 10000,
                'image' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Udang Selai Kacang',
                'description' => 'Udang Selai Kacang milik resto mayo dengan ini bisa membuat pelanggan terpikat',
                'price' => 10000,
                'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Kopi Susu Aren Mayo',
                'description' => 'Espresso robusta & arabika pilihan berpadu susu segar krimi dan sirup gula aren murni disajikan dingin menyegarkan.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Teh Manis Melati Segar',
                'description' => 'Seduhan teh melati wangi alami pilihan khas nusantara disajikan dingin dengan es batu kristal penyejuk dahaga.',
                'price' => 8000,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Jus Alpukat Kocok Mayo',
                'description' => 'Daging alpukat mentega segar kental dikocok dengan susu kental manis cokelat dan krim lembut kaya nutrisi.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=600&q=80',
                'is_available' => true,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Milshake Milo',
                'description' => 'Milshake Milo yang segar membuat yang memesan ini pasti akan senang',
                'price' => 15000,
                'image' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=600&q=80',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
