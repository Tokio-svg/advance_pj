<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $items = Shop::with('area')->with('genre')->get();
        return view('index', [
            'items' => $items,
        ]);
    }
}
