<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('includes.navbar')
    @section('content')
    <div class="container">
        <div class="card m-3 p-3">
            <header class="modal-header">
                <h3>Place your Order</h3>
            </header>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('orders.store')}}" method="post">
                @csrf
                <div class="form-group">
                    Name:<input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    Email:<input type="text" name="email" id="email" value="{{old('email')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    Phone:<input type="number" name="phone" id="phone" value="{{old('phone')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group">
                    Street Address:<input type="text" name="streetaddress" id="streetaddress" value="{{old('streetaddress')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    Pincode:<input type="text" name="pin" id="pin" value="{{old('pin')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    City:<input type="text" name="city" id="city" value="{{old('city')}}" class="form-control">
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    Product : 
                    <select name="product_id" id="product_id" value="{{old('product_id')}}" required class="form-control">
                        <option value="select" selected hidden >---Choose a Product ---</option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="price_div" style="display:none;">
                    Price: <input type="text" name="price" id="price"  class="form-control" readonly>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#product_id').change(function() {
                            var productId = $(this).val();
                            if (productId !== "select") {
                                $.ajax({
                                    url: "{{ route('price') }}", 
                                    type: "GET",
                                    data: { product_id: productId },
                                    success: function(response) {
                                        if (response.success) {
                                            $('#price').val(response.price);
                                            $('#price_div').show();
                                        }
                                    }
                                });
                            } else {
                                $('#price_div').hide();
                            }
                        });
                    });
                </script>
                <button type="submit" class="btn btn-sm btn-primary">Place Order</button>
            </form>
        </div>
    </div>
    @endsection
</body>
</html>
