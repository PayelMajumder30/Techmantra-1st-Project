<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('includes.header')
    @extends('includes.navbar')
    @section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">{{ (Session::get('success')) }}</div> 
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ (Session::get('error')) }}</div>               
    @endif
    <div class="container">
        <div class="form-group">
            <table class="table table-bordered">
                <header class="modal-header">
                    <h3>Your orders</h3>
                </header>
                <div class="class form-group">
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price:</th>
                        <th>Action</th>
                    </tr>
                    @foreach($carts as $cart)
                    <tr>
                        <td>{{$cart->name}}</td>
                        <td>{{$cart->quantity}}</td>
                        <td>{{$cart->price}}</td>
                        <td>{{$cart->total_price}}</td>
                        <td>
                            <form action="{{route('cart.delete', $cart->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete your order?')">Delete Item</button>
                            </form>         
                        </td> 
                    </tr>
                    @endforeach
                </div>               
            </table>
            <button type="submit" class="btn btn-sm btn-outline-primary" onclick="window.location='{{route('cart.view')}}'">Back to cart</button>
        </div>
    </div>
    @endsection
</body>
</html>