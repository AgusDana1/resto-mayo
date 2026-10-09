<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_cart_via_ajax(): void
    {
        $category = Category::create([
            'name' => 'Makanan Utama',
            'slug' => 'makanan-utama',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng Spesial Resto Mayo',
            'slug' => 'nasi-goreng-spesial-resto-mayo',
            'description' => 'Nasi goreng harum dengan topping telur dan bumbu khas.',
            'price' => 28000,
            'is_available' => true,
        ]);

        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
            'ngrok-skip-browser-warning' => 'true',
        ])->postJson("/cart/add/{$product->id}", [
            'quantity' => 1,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'product_name' => 'Nasi Goreng Spesial Resto Mayo',
            'totalQuantity' => 1,
            'cartCount' => 1,
        ]);

        $this->assertEquals(1, session('cart')[$product->id]['quantity']);
    }

    public function test_cart_works_behind_trusted_proxy_headers(): void
    {
        $category = Category::create([
            'name' => 'Dimsum Premium',
            'slug' => 'dimsum-premium',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Dimsum Mentai Mayo Lava',
            'slug' => 'dimsum-mentai-mayo-lava',
            'description' => 'Dimsum lembut saus mentai gurih.',
            'price' => 25000,
            'is_available' => true,
        ]);

        $response = $this->withServerVariables([
            'HTTP_X_FORWARDED_FOR' => '1.2.3.4',
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'HTTP_X_FORWARDED_HOST' => '8c67-2404-c0-bf01-23e7-5d76-33e9-9dc9-c2a0.ngrok-free.app',
            'HTTP_X_FORWARDED_PORT' => '443',
        ])->postJson("/cart/add/{$product->id}", [
            'quantity' => 2,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'totalQuantity' => 2,
        ]);
    }
}
