@extends('layouts.admin-layout')
@section('title', 'Update product')
@section('heading', 'Update product')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @elseif($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('products.update', ['id' => $product->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card m-2 p-2">
            <div class="form-group">
                Name: <input type="text" value="<?php echo $product['name'];?>" name="editname" id="editname" class="form-control">
            </div>
            <div class="form-group">
                Quantity: <input value="<?php echo $product['quantity'];?>" type="number" name="editquantity" id="editquantity" class="form-control">
            </div>
            <div class="form-group">
                Price: <input type="number" value="<?php echo $product['price'];?>" name="editprice" id="editprice" class="form-control">
            </div>
       <div class="form-group">
                Product Image: <img src="{{ asset($product['image']) }}" alt="No Image" title="<?php echo $product['name'];?>'s Pic" height="120px" width="120px" class="img-thumbnail">
                <input type="file"  name="editimage" id="editimage" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('products.list') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@stop