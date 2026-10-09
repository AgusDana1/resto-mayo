<?php

namespace App\Http\Controllers;

use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->where('is_available', true);
            },
        ])->get();

        return view('menu.index', compact('categories'));
    }
}
