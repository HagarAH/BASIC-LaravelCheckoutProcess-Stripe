<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link href="resources/css/app.css" rel="stylesheet"/>

    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-200">
<div class=" flex-col min-h-full ">
    <p class="font-semibold mx-2 my-2 text-2xl">MY CART</p>
    @php
        $total = 0;
    @endphp

    <div class="max-h-screen ">
        <div class="flex-col h-[38.6rem] overflow-hidden overflow-y-visible mt-2 mx-10 z-10 bg-white">
            @foreach($products as $product)
                <div class="m-2 my-2 border-black border-2 flex justify-between">
                    <img src="{{$product->image}}" class="max-w-xs"/>
                    <div class=" flex">
                        <p>{{$product->name}}</p>

                    </div>
                    <div class="border-black border-l p-2">
                        <div class="font-semibold text-lg">
                            <p>{{$product->price}}</p>
                        </div>
                    </div>



                    @php
                        $total += $product->price;
                    @endphp
                </div>
            @endforeach
        </div>
    </div>

        <div class="flex justify-end ">

            <form class="mx-3" action="checkout" method="POST" action="POST" >
                @CSRF
                <p> Total: {{$total}}$</p>

                <button class="p-2 bg-green-500 m-2 text-gray-800 font-semibold" type="submit">Checkout</button>
            </form>
        </div>
    </div>

</div>


</body>
</html>
