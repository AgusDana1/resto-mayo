<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_guest_cannot_access_admin_products_and_redirects_to_login(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_admin_can_view_product_create_page(): void
    {
        Category::create(['name' => 'Makanan Utama']);

        $response = $this->actingAs($this->admin)->get(route('admin.products.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Produk Menu Baru');
        $response->assertSee('Makanan Utama');
    }

    public function test_admin_can_store_new_product_with_image_url(): void
    {
        $category = Category::create(['name' => 'Dimsum']);

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Dimsum Mozarella Mayo',
            'description' => 'Dimsum lembut dengan lelehan keju mozarella dan mayonise khas.',
            'price' => 22000,
            'image_url' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=600&q=80',
            'is_available' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan.');

        $this->assertDatabaseHas('products', [
            'name' => 'Dimsum Mozarella Mayo',
            'category_id' => $category->id,
            'price' => 22000,
            'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=600&q=80',
            'is_available' => true,
        ]);
    }

    public function test_admin_can_store_new_product_with_uploaded_file(): void
    {
        Storage::fake('public');
        $category = Category::create(['name' => 'Minuman']);

        $file = UploadedFile::fake()->image('es_teh.jpg', 600, 600);

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Es Teh Melati Spesial',
            'description' => 'Es teh melati segar dingin.',
            'price' => 8000,
            'image' => $file,
            'is_available' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::where('name', 'Es Teh Melati Spesial')->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), []);

        $response->assertSessionHasErrors(['category_id', 'name', 'price']);
    }

    public function test_admin_can_view_product_detail_and_edit_page(): void
    {
        $category = Category::create(['name' => 'Camilan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Risoles Mayo Super',
            'description' => 'Risoles gurih lezat.',
            'price' => 15000,
            'is_available' => true,
        ]);

        $showResponse = $this->actingAs($this->admin)->get(route('admin.products.show', $product));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Risoles Mayo Super');

        $editResponse = $this->actingAs($this->admin)->get(route('admin.products.edit', $product));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Ubah Produk Menu');
        $editResponse->assertSee('Risoles Mayo Super');
    }

    public function test_admin_can_update_product(): void
    {
        $category = Category::create(['name' => 'Makanan']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng Biasa',
            'price' => 20000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Nasi Goreng Spesial Mayo',
            'price' => 28000,
            'description' => 'Nasi goreng dengan bumbu rempah pilihan.',
            'is_available' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Nasi Goreng Spesial Mayo',
            'price' => 28000,
        ]);
    }
}
