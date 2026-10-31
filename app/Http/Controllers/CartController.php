<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['qty']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = DB::table('producttbl')->where('proid', $id)->first();
        abort_if(!$product, 404);

        $cart = session('cart', []);
        $qty  = min(10, max(1, (int) $request->input('qty', 1)));

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = min(10, $cart[$id]['qty'] + $qty);
        } else {
            $cart[$id] = [
                'name'  => $product->proname,
                'price' => $product->price,
                'image' => $product->img1,
                'qty'   => $qty,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Added to cart');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = min(10, max(1, (int) $request->input('qty', 1)));
            session(['cart' => $cart]);
        }

        return back();
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back();
    }
}