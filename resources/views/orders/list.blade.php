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
    @extends('includes.navbar');
    @section('content');
    @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
    <div class="container">
        <div class="card m-3 p-3">
            <table class="table-hover">
                <form action="" method="GET">
                <div class="form-group">
                    <input type="text" name="search" id="" placefolder="search by name" class="form-control" value="{{request('search')}}">  
                    <button type="submit" class="btn btn-sm btn-outline-primary">Search</button>
                    <a href="{{route('orders.list')}}" class="btn btn-sm btn-outline-info">Refresh</a>
                </div>
                        <tr>
                            <th>Product details</th>
                            <th>Customer details</th>
                            <th>Order details</th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <ul>
                                    <li>{{$order->product ? $order->product->name : ""}}</li>
                                    <li>{{$order->product ? $order->product->price : ""}}</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Name:{{$order->name}}</li>
                                    <li>Email:{{$order->email}}</li>
                                    <li>Phone:{{$order->phone}}</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Street Address:{{$order->streetaddress}}</li>
                                    <li>Pincode:{{$order->pin}}</li>
                                    <li>City:{{$order->city}}</li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </div>
                </form>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
    @endsection
</body>
</html>