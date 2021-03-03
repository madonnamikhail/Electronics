<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        #parent{
            margin: 10px auto;
            width:70%;
            text-align: center;
            /* display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            align-content: center; */
        }
        #title{
            background-color: blue;
            color: white;
            font-weight: bold;
            padding: 10px;
            font-size: 30px;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 16px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="parent">
        <div id="title">{{ $orderInsert['title'] }}</div>
        <h1> Hi  {{ $orderInsert['userName'] }},</h1>
        <h3> Your order ID {{ $orderInsert['order_id'] }}  </h3>
        <p>Just to let you know - we have recieved your order, and it is now being processed.</p>
        <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>{{$product->name_en}}</td>
                <td>{{$product->pivot->quantity}}</td>
                <td>{{$product->price}}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="2" style="font-weight: bold;">Subtotal: </td>
            <td>{{$orderInsert['subtotal']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Payment Method:</td>
            <td>{{$orderInsert['payment_method']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Shipping:</td>
            <td>{{$orderInsert['payment_method']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">PromoCode Used:</td>
            {{-- @php
                $orderInsert['promoCodes_id'] = true;
            @endphp --}}
            @if($orderInsert['flag'])
                <td>{{$orderInsert['promoCodes_id']}}
                <br>
                    @if($orderInsert['rangValue'] != 1 and $orderInsert['out_of_date'] != 1)
                    <div class="alert alert-danger">
                        {{ $orderInsert['rangValue'] }} and {{ $orderInsert['out_of_date'] }}
                    </div>
                    @elseif($orderInsert['rangValue'] != 1)
                        <div class="alert alert-danger">
                            {{ $orderInsert['rangValue'] }}
                        </div>
                    @elseif($orderInsert['out_of_date'] != 1)
                        <div class="alert alert-danger">
                            {{ $orderInsert['out_of_date'] }}
                        </div>
                    @endif
                </td>

            @else
                <td>No promocode used</td>
            @endif
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Grand Total:</td>
            @php
                if($orderInsert['discount'] != 1){
                    if($orderInsert['payment_method'] == "Master Card ( 10% Discount )")
                        $grand_total= $orderInsert['subtotal'] * (0.9) * $orderInsert['discount'];

                    elseif ($orderInsert['payment_method'] == "Cash On Delivery ( +5 EGP )")
                        $grand_total= $orderInsert['subtotal'] + (5) * $orderInsert['discount'];
                    // echo $grand_total . "EGP";
                }else{
                    if($orderInsert['payment_method'] == "Master Card ( 10% Discount )")
                        $grand_total= $orderInsert['subtotal'] * (0.9);

                    elseif ($orderInsert['payment_method'] == "Cash On Delivery ( +5 EGP )")
                        $grand_total= $orderInsert['subtotal'] + (5);
                    // echo $grand_total . "EGP";
                }
            @endphp
            <td>{{$grand_total}} EGP</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Mailing Address:</td>
            <td>{{$orderInsert['payment_method']}}</td>
        </tr>
        </table>


    </div>
</body>
</html>
