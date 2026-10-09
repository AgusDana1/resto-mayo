<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds for realistic sample orders.
     */
    public function run(): void
    {
        $tables = Table::all();
        if ($tables->isEmpty()) {
            return;
        }

        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $risol = $products->firstWhere('name', 'Risoles Mayonise Keju Lumer') ?? $products->first();
        $nasgor = $products->firstWhere('name', 'Nasi Goreng Spesial Resto Mayo') ?? $products->skip(1)->first() ?? $products->first();
        $teh = $products->firstWhere('name', 'Es Teh Manis Melati Segar') ?? $products->last();

        // 1. Order Pending (Pesanan Masuk Baru)
        $order1 = Order::updateOrCreate(
            ['order_number' => 'ORD-1001'],
            [
                'table_id' => $tables[0]->id,
                'customer_name' => 'Budi Santoso',
                'total_amount' => 68000,
                'status' => 'pending',
                'ordered_at' => now()->subMinutes(12),
            ]
        );

        OrderItem::firstOrCreate([
            'order_id' => $order1->id,
            'product_id' => $risol->id,
        ], [
            'quantity' => 2,
            'price' => $risol->price,
            'total' => $risol->price * 2,
            'notes' => 'Mayonise ekstra banyak',
        ]);

        OrderItem::firstOrCreate([
            'order_id' => $order1->id,
            'product_id' => $nasgor->id,
        ], [
            'quantity' => 1,
            'price' => $nasgor->price,
            'total' => $nasgor->price,
            'notes' => 'Pedas sedang, telur ceplok matang',
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order1->id],
            [
                'method' => 'qris',
                'status' => 'paid',
                'amount' => 68000,
                'paid_at' => now()->subMinutes(10),
            ]
        );

        // 2. Order Processing (Sedang Dimasak di Dapur)
        $order2 = Order::updateOrCreate(
            ['order_number' => 'ORD-1002'],
            [
                'table_id' => $tables[1]->id,
                'customer_name' => 'Siti Rahma',
                'total_amount' => 44000,
                'status' => 'processing',
                'ordered_at' => now()->subMinutes(25),
            ]
        );

        OrderItem::firstOrCreate([
            'order_id' => $order2->id,
            'product_id' => $risol->id,
        ], [
            'quantity' => 2,
            'price' => $risol->price,
            'total' => $risol->price * 2,
            'notes' => 'Goreng garing renyah',
        ]);

        OrderItem::firstOrCreate([
            'order_id' => $order2->id,
            'product_id' => $teh->id,
        ], [
            'quantity' => 1,
            'price' => $teh->price,
            'total' => $teh->price,
            'notes' => 'Es batu sedikit (less ice)',
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order2->id],
            [
                'method' => 'gopay',
                'status' => 'paid',
                'amount' => 44000,
                'paid_at' => now()->subMinutes(23),
            ]
        );

        // 3. Order Ready (Siap Diantar ke Meja)
        $order3 = Order::updateOrCreate(
            ['order_number' => 'ORD-1003'],
            [
                'table_id' => $tables[2]->id,
                'customer_name' => 'Dimas Pratama',
                'total_amount' => 32000,
                'status' => 'ready',
                'ordered_at' => now()->subMinutes(35),
            ]
        );

        OrderItem::firstOrCreate([
            'order_id' => $order3->id,
            'product_id' => $nasgor->id,
        ], [
            'quantity' => 1,
            'price' => $nasgor->price,
            'total' => $nasgor->price,
            'notes' => 'Tidak pakai daun bawang',
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order3->id],
            [
                'method' => 'dana',
                'status' => 'paid',
                'amount' => 32000,
                'paid_at' => now()->subMinutes(33),
            ]
        );
    }
}
