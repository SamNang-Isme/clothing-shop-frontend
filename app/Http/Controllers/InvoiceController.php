<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private function load(string $invoiceNo): array
    {
        // Only the browser session that placed the order may open its invoice.
        abort_unless(in_array($invoiceNo, session('my_invoices', []), true), 403);

        $order = DB::table('ordertbl')->where('invoice_no', $invoiceNo)->first();
        abort_if(!$order, 404);

        $items = DB::table('orderitemtbl')->where('orderid', $order->orderid)->get();

        return [$order, $items];
    }

    // Invoice page (HTML)
    public function show(string $invoiceNo)
    {
        [$order, $items] = $this->load($invoiceNo);

        return view('invoice.show', ['order' => $order, 'items' => $items, 'download' => false]);
    }

    // Same invoice downloaded as a standalone .html file
    public function download(string $invoiceNo)
    {
        [$order, $items] = $this->load($invoiceNo);

        $html = view('invoice.show', ['order' => $order, 'items' => $items, 'download' => true])->render();

        return response($html, 200, [
            'Content-Type'        => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $order->invoice_no . '.html"',
        ]);
    }
}
