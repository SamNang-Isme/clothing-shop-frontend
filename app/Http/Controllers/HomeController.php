<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private function products()
    {
        return DB::table('producttbl')
            ->join('categorytbl', 'producttbl.cateid', '=', 'categorytbl.cateid')
            ->select('producttbl.*', 'categorytbl.catetitle');
    }

    public function index()
    {
       $categories  = DB::table('categorytbl')->where('status', 'Active')->get();
        $newProducts = $this->products()->orderByDesc('producttbl.created_at')->limit(10)->get();
        $recommended = $this->products()->inRandomOrder()->limit(8)->get();
        $slides      = DB::table('settingtbl')->where('type', 'Slide')->where('status', 'Active')->get();

        return view('home.home', compact('categories', 'newProducts', 'recommended', 'slides'));
    }
}