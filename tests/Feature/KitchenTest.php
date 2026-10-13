<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KitchenTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_guest_cannot_access_kitchen_and_redirects_to_login(): void
    {
        $response = $this->get(route('admin.kitchen.index'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_kitchen_displays_minutes_when_under_one_hour(): void
    {
        $table = Table::create(['table_number' => 1, 'table_code' => 'M01', 'capacity' => 4]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-01',
            'table_id' => $table->id,
            'customer_name' => 'Budi',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);
        $order->created_at = now()->subMinutes(15);
        $order->save();

        $response = $this->actingAs($this->admin)->get(route('admin.kitchen.index'));
        $response->assertStatus(200);
        $response->assertSee('15 mnt lalu');
    }

    public function test_kitchen_displays_hours_when_between_one_hour_and_24_hours(): void
    {
        $table = Table::create(['table_number' => 2, 'table_code' => 'M02', 'capacity' => 4]);

        // Order 75 minutes ago -> 1 jam 15 mnt lalu
        $order1 = Order::create([
            'order_number' => 'ORD-TEST-02',
            'table_id' => $table->id,
            'customer_name' => 'Siti',
            'total_amount' => 45000,
            'status' => 'processing',
        ]);
        $order1->created_at = now()->subMinutes(75);
        $order1->save();

        // Order 120 minutes ago -> 2 jam lalu
        $order2 = Order::create([
            'order_number' => 'ORD-TEST-03',
            'table_id' => $table->id,
            'customer_name' => 'Rina',
            'total_amount' => 35000,
            'status' => 'pending',
        ]);
        $order2->created_at = now()->subMinutes(120);
        $order2->save();

        $response = $this->actingAs($this->admin)->get(route('admin.kitchen.index'));
        $response->assertStatus(200);
        $response->assertSee('1 jam 15 mnt lalu');
        $response->assertSee('2 jam lalu');
    }

    public function test_kitchen_displays_days_when_over_24_hours(): void
    {
        $table = Table::create(['table_number' => 3, 'table_code' => 'M03', 'capacity' => 4]);

        // Order 1440 minutes ago (24 jam tepat) -> 1 hari lalu
        $order1 = Order::create([
            'order_number' => 'ORD-TEST-04',
            'table_id' => $table->id,
            'customer_name' => 'Dewi',
            'total_amount' => 25000,
            'status' => 'ready',
        ]);
        $order1->created_at = now()->subMinutes(1440);
        $order1->save();

        // Order 6189 minutes ago (4 hari 7 jam 9 mnt) -> 4 hari 7 jam lalu
        $order2 = Order::create([
            'order_number' => 'ORD-TEST-05',
            'table_id' => $table->id,
            'customer_name' => 'Andi',
            'total_amount' => 30000,
            'status' => 'pending',
        ]);
        $order2->created_at = now()->subMinutes(6189);
        $order2->save();

        $response = $this->actingAs($this->admin)->get(route('admin.kitchen.index'));
        $response->assertStatus(200);
        $response->assertSee('1 hari lalu');
        $response->assertSee('4 hari 7 jam lalu');
    }
}
