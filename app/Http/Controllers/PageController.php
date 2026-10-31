<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    private function page($slug)
    {
        $page = DB::table('pagetbl')->where('slug', $slug)->where('status', 'Active')->first();
        abort_if(!$page, 404);

        return $page;
    }

    public function about()
    {
        return view('about.about', ['page' => $this->page('about')]);
    }

    public function contact()
    {
        $contacts = DB::table('settingtbl')->where('type', 'Contact')->where('status', 'Active')->get();

        return view('contact.contact', [
            'page'  => $this->page('contact'),
            'phone' => optional($contacts->firstWhere('title', 'Phone'))->description,
            'email' => optional($contacts->firstWhere('title', 'Email'))->description,
        ]);
    }
}