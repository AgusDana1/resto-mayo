<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present_on_responses(): void
    {
        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_guest_is_redirected_when_accessing_admin_endpoints(): void
    {
        $endpoints = [
            route('admin.dashboard'),
            route('admin.orders.index'),
            route('admin.products.index'),
            route('admin.categories.index'),
            route('admin.kitchen.index'),
        ];

        foreach ($endpoints as $url) {
            $response = $this->get($url);
            $response->assertRedirect(route('login'));
            $response->assertSessionHas('error');
        }
    }

    public function test_authenticated_non_admin_user_gets_403_forbidden(): void
    {
        $nonAdmin = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($nonAdmin)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_cannot_add_unavailable_product_to_cart(): void
    {
        $category = Category::create(['name' => 'Dimsum']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Dimsum Mozarella Sold Out',
            'price' => 20000,
            'is_available' => false,
        ]);

        $response = $this->postJson(route('cart.add', $product), [
            'quantity' => 1,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);

        $this->assertEmpty(session('cart', []));
    }

    public function test_cart_quantity_is_clamped_to_safe_bounds(): void
    {
        $category = Category::create(['name' => 'Minuman']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Es Teh Melati',
            'price' => 5000,
            'is_available' => true,
        ]);

        // Attempt quantity of 999999
        $response = $this->postJson(route('cart.add', $product), [
            'quantity' => 999999,
        ]);

        $response->assertOk();
        $this->assertEquals(99, session('cart')[$product->id]['quantity']);
    }

    public function test_checkout_sanitizes_xss_in_customer_name_and_notes(): void
    {
        $table = Table::create([
            'table_number' => 5,
            'table_code' => 'M05',
            'status' => 'available',
        ]);

        $category = Category::create(['name' => 'Makanan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng Spesial',
            'price' => 25000,
            'is_available' => true,
        ]);

        // Put item in cart with potential XSS script in notes
        session([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 25000,
                    'quantity' => 1,
                    'notes' => '<script>alert("hack")</script>Pedas sedikit',
                ],
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'customer_name' => '<script>alert("xss")</script>Agus Dana',
            'table_id' => $table->id,
            'payment_method' => 'qris',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Agus Dana',
            'total_amount' => 25000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'notes' => 'Pedas sedikit',
        ]);
    }

    public function test_checkout_protects_against_price_tampering_in_session(): void
    {
        $table = Table::create([
            'table_number' => 6,
            'table_code' => 'M06',
            'status' => 'available',
        ]);

        $category = Category::create(['name' => 'Makanan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Steak Wagyu Mayo',
            'price' => 150000,
            'is_available' => true,
        ]);

        // Attacker tampers cart session price to 100 rupiah
        session([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 100, // tampered
                    'quantity' => 2,
                ],
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'customer_name' => 'Budi Santoso',
            'table_id' => $table->id,
            'payment_method' => 'qris',
        ]);

        $response->assertSessionHasNoErrors();

        // Database order must reflect genuine DB price (150,000 * 2 = 300,000)
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Budi Santoso',
            'total_amount' => 300000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'price' => 150000,
            'total' => 300000,
        ]);
    }

    public function test_checkout_rejects_order_if_product_became_unavailable(): void
    {
        $table = Table::create([
            'table_number' => 7,
            'table_code' => 'M07',
            'status' => 'available',
        ]);

        $category = Category::create(['name' => 'Makanan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Menu Langka',
            'price' => 50000,
            'is_available' => false,
        ]);

        session([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 50000,
                    'quantity' => 1,
                ],
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'customer_name' => 'Dewi Lestari',
            'table_id' => $table->id,
            'payment_method' => 'qris',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('orders', [
            'customer_name' => 'Dewi Lestari',
        ]);
    }

    public function test_login_route_throttles_after_repeated_failed_attempts(): void
    {
        // 5 allowed attempts
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('login.post'), [
                'email' => 'admin@resto.test',
                'password' => 'wrongpassword',
            ]);
            $response->assertStatus(302);
        }

        // 6th attempt should be blocked with 429 Too Many Requests
        $blockedResponse = $this->post(route('login.post'), [
            'email' => 'admin@resto.test',
            'password' => 'wrongpassword',
        ]);

        $blockedResponse->assertStatus(429);
    }

    public function test_search_sanitizes_input_and_filters_correctly(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Dimsum']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Dimsum Mentai Spesial',
            'price' => 20000,
            'is_available' => true,
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Siomay Ayam Lezat',
            'price' => 20000,
            'is_available' => true,
        ]);

        // Search with XSS script tags and query
        $response = $this->actingAs($admin)->get(route('admin.products.index', [
            'search' => '<script>alert("xss")</script>Mentai',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Dimsum Mentai Spesial');
        $response->assertDontSee('Siomay Ayam Lezat');
        $response->assertDontSee('<script>alert("xss")</script>', false);
    }
}
