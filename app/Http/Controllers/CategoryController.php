<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // All categories with product count
    public function index()
    {
        $categories = DB::table('categorytbl')
            ->leftJoin('producttbl', 'categorytbl.cateid', '=', 'producttbl.cateid')
            ->select('categorytbl.*', DB::raw('COUNT(producttbl.proid) as products_count'))
            ->where('categorytbl.status', 'Active')
            ->groupBy('categorytbl.cateid')
            ->get();

        return view('category.index', compact('categories'));
    }

    // Products in one category
    public function show($id)
    {
        $category = DB::table('categorytbl')->where('cateid', $id)->where('status', 'Active')->first();
        abort_if(!$category, 404);

        $products = DB::table('producttbl')
            ->join('categorytbl', 'producttbl.cateid', '=', 'categorytbl.cateid')
            ->select('producttbl.*', 'categorytbl.catetitle')
            ->where('producttbl.cateid', $id)
            ->orderByDesc('producttbl.created_at')
            ->paginate(12);

        return view('category.show', compact('category', 'products'));
    }
}