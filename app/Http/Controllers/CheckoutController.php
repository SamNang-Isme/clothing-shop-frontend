<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Re-read cart lines from the DB so prices/names can't be stale or tampered with.
    private function freshCart(): array
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return [[], 0];
        }

        $products = DB::table('producttbl')->whereIn('proid', array_keys($cart))->get()->keyBy('proid');

        $lines = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $p = $products->get($id);
            if (!$p) {
                continue; // product was removed
            }
            $qty      = min(10, max(1, (int) $item['qty']));
            $subtotal = $p->price * $qty;
            $total   += $subtotal;
            $lines[]  = [
                'proid'    => $p->proid,
                'proname'  => $p->proname,
                'image'    => $p->img1,
                'price'    => $p->price,
                'qty'      => $qty,
                'subtotal' => $subtotal,
            ];
        }

        return [$lines, $total];
    }

    public function index()
    {
        [$lines, $total] = $this->freshCart();

        if (empty($lines)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        return view('checkout.index', compact('lines', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'phone'         => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{6,30}$/'],
            'email'         => ['nullable', 'email', 'max:150'],
            'address'       => ['required', 'string', 'max:500'],
            'note'          => ['nullable', 'string', 'max:500'],
        ]);

        [$lines, $total] = $this->freshCart();
        if (empty($lines)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        $invoiceNo = DB::transaction(function () use ($data, $lines, $total) {
            $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $orderId = DB::table('ordertbl')->insertGetId([
                'invoice_no'    => $invoiceNo,
                'customer_name' => $data['customer_name'],
                'phone'         => $data['phone'],
                'email'         => $data['email'] ?? null,
                'address'       => $data['address'],
                'note'          => $data['note'] ?? null,
                'total'         => $total,
                'status'        => 'Pending',
                'created_at'    => now(),
                'updated_at'    => now(),
            ], 'orderid');

            DB::table('orderitemtbl')->insert(array_map(fn ($l) => [
                'orderid'  => $orderId,
                'proid'    => $l['proid'],
                'proname'  => $l['proname'],
                'price'    => $l['price'],
                'qty'      => $l['qty'],
                'subtotal' => $l['subtotal'],
            ], $lines));

            return $invoiceNo;
        });

        session()->forget('cart');
        // Remember which invoices this browser session created (access control for the invoice page)
        session()->push('my_invoices', $invoiceNo);

        return redirect()->route('invoice.show', $invoiceNo)->with('success', 'Order placed successfully!');
    }
}
