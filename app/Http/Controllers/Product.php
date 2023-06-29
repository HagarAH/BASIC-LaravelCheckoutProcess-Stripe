<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class Product extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = \App\Models\Product::all();
        return view('product.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRETKEY'));

        $products = \App\Models\Product::all();
        $total_price=0;
        foreach ($products as $product) {
            $lineItems[] = [

                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->image]

                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => 1,

            ];
        }

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true),
            'cancel_url' => route('checkout.cancel',[],true),
        ]);

        $order= new Order();
        $order->status='unpaid';
        $order->total_price=
        return redirect($checkout_session->url);
    }

    public function cancel()
    {

    }

    public function success()
    {


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
