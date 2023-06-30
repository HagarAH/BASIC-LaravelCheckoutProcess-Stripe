<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Mockery\Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function checkout()
    {
        $stripe = new StripeClient(env('STRIPE_SECRETKEY'));

        $products = \App\Models\Product::all();
        $total_price=0;
        foreach ($products as $product) {
            $total_price=+$product->price;
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
            'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel',[],true),
        ]);

        $order= new Order();
        $order->status='unpaid';
        $order->total_price=$total_price;
        $order->session_id=$checkout_session->id;
        $order->save();
        return redirect($checkout_session->url);
    }

    public function cancel()
    {

    }

    /**
     * @throws ApiErrorException
     */
    public function success(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRETKEY'));
        $sessionId = $request->get('session_id');
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if (!$session) {
            throw new Exception('Session not found');
        }
        $customer = $session->customer_details;




        if (!$customer) {
            throw new NotFoundHttpException('Customer not found');
        }

        return view('product.checkout.success', compact('customer'));
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
