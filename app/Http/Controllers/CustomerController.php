<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Memulai sesi pelanggan dengan sanitasi nama dan pemilihan meja.
     */
    public function start(Request $request): RedirectResponse
    {
        $cleanName = strip_tags(trim((string) $request->input('name', '')));
        $request->merge(['name' => $cleanName]);

        $validated = $request->validate([
            'table_id' => ['nullable', 'exists:tables,id'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $table = null;
        if (! empty($validated['table_id'])) {
            $table = Table::find($validated['table_id']);
        }

        session([
            'table_id' => $table?->id,
            'table_code' => $table?->table_code,
            'customer_name' => $cleanName,
        ]);

        return redirect()->route('menu.index');
    }
}
