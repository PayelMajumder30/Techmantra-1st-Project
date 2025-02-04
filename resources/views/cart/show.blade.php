<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="form-group">
            <table>
                <form action="{{route()}}" method="GET"></form>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price:</th>
                    <th>Action</th>
                </tr>
                @foreach($carts as $cart)
                    <td>{{$cart->name}}</td>
                    <td>{{$cart->quantity}}</td>
                    <td>{{$cart->price}}</td>
                    <td>{{{{$cart->total_price}}}}</td>
                    <td></td>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>