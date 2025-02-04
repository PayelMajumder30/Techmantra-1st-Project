
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
{{-- Body of the page --}}
@section('content')

@if (Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@elseif(Session::has('error'))
<div class="alert alert-danger">{{Session::get('error')}}</div>
@endif

<div class="card m-3 p-3">
    <div class="form-group">
        <header class="modal-header">
            <h3>Product List</h3>
        </header>
        <div class="d-flex justify-content-end">
            <a href="{{ route('products.add') }}" class="btn btn-sm btn-info">Add product</a>
        </div>       
    </div>
    <table class="table table-hover">
        <form method="GET" action="{{ route('products.list') }}">
        <tr>
            <th>Name:
                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Enter product name">
            </th>
            <th>Quantity:</th>
            <th>Price:</th>
            <th>Image:</th>
            <th>Action</th>
            <th>
                <button type="submit" class="btn btn-sm btn-outline-info">Search</button>
                <a href="{{ route('products.list') }}" class="btn btn-sm btn-outline-primary">Refesh</a>
                <a href="{{route('products.add')}}" class="btn btn-sm btn-outline-secondary">Back</a>
            </th>
        </tr>
        @foreach($products as $product)
        {{-- @php
         dd($products);
         @endphp --}}
       
        <tr>            
            <td>{{$product->name}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->price}}</td>
            <td>
                <img src="{{ asset($product->image) }}" alt="No Image" title="<?php echo $product['name'];?>'s Pic" height="120px" width="120px" class="img-thumbnail">
                {{-- <img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" width="100" height="100"></td>--}}
            </td>
            <td>
                <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-sm btn-outline-info">Edit</a> |    
                <form action="{{route('products.delete', ['id' => $product->id])}}" method="POST" >
                    @csrf 
                    @method('DELETE') 
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button> |
                    </form>  
                    <form action="{{route('cart.add')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="number" name="quantity" min="1" max="{{ $product->quantity }}" class="form-control">
                        <button type="submit" class="btn btn-sm btn-outline-success">Add to cart</button>
                    </form>             
            </td>
        </tr>
        @endforeach
        </form>
    </table>
    @endsection
</body>
</html>
</div>  