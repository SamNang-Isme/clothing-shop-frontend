<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('producttbl')
            ->join('categorytbl', 'producttbl.cateid', '=', 'categorytbl.cateid')
            ->select('producttbl.*', 'categorytbl.catetitle')
            ->when($request->q, fn ($q, $term) => $q->where('producttbl.proname', 'like', "%{$term}%"))
            ->orderByDesc('producttbl.created_at')
            ->paginate(12)
            ->withQueryString();

        return view('product.index', compact('products'));
    }

    public function show($id)
    {
        $product = DB::table('producttbl')
            ->join('categorytbl', 'producttbl.cateid', '=', 'categorytbl.cateid')
            ->select('producttbl.*', 'categorytbl.catetitle')
            ->where('producttbl.proid', $id)
            ->first();
        abort_if(!$product, 404);

        $related = DB::table('producttbl')
            ->join('categorytbl', 'producttbl.cateid', '=', 'categorytbl.cateid')
            ->select('producttbl.*', 'categorytbl.catetitle')
            ->where('producttbl.cateid', $product->cateid)
            ->where('producttbl.proid', '!=', $id)
            ->limit(4)
            ->get();

        return view('product.show', compact('product', 'related'));
    }
}