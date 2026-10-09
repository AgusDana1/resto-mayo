<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'table' => 'required|in:products,orders,customers',
            'name' => 'required|string|max:255',
        ]);

        $table = Table::where('name', $request->table)->firstOrFail();

        session([
            'table_id' => $table->id,
            'table_code' => $table->code,
            'customer_name' => $request->name,
        ]);

        return redirect()->route('menu.index');
    }
}
