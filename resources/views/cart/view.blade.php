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
    <div class="container">
        <header class="modal-header">
            <h3>Your Cart</h3>
        </header>
        @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <form action="{{ route('cart.placeOrder') }}" method="POST">
            @csrf
        <table class="table table-bordered">
            <tr>
                <th>Customer name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Street address</th>
                <th>Pincode</th>
                <th>City</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
            @foreach($cart as $id => $item)
            <tr>
                <td>
                    <div> 
                        <select name="order_id[{{$id}}]" id="order_id_{{$id}}" required class="form-control order-select" >
                            <option value="select" selected disabled >---Choose the name ---</option>
                            @foreach($orders as $order)
                                <option value="{{$order->id}}">{{$order->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                   <div class="form-group" id="email_div_{{$id}}">
                        <input type="text" name="email[{{$id}}]" id="email_{{$id}}" class="form-control" readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group" id="phone_div_{{$id}}" >
                        <input type="text" name="phone[{{$id}}]" id="phone_{{$id}}" class="form-control" readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group" id="streetaddress_div_{{$id}}">
                        <input type="text" name="streetaddress[{{$id}}]" id="streetaddress_{{$id}}" class="form-control" readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group" id="pin_div_{{$id}}" >
                        <input type="text" name="pin[{{$id}}]" id="pin_{{$id}}" class="form-control" readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group" id="city_div_{{$id}}" >
                        <input type="text" name="city[{{$id}}]" id="city_{{$id}}" class="form-control" readonly>
                    </div>
                </td>
                <td>{{ $item['name']}}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary decrement" onclick="decrement({{$id}})">-</button>
                    <input type="number" class="form-control text-center quantity" id="quantity-{{$id}}" value="{{$item['quantity']}}" min="1" disabled>
                    <button class="btn btn-sm btn-outline-secondary increment" onclick="increment({{$id}})">+</button>
                </td>
                <td class="price" id="price-{{$id}}">{{$item['price']}}</td>
                <td class="total-price" id="total-price-{{$id}}">{{$item['total_price']}}</td>              
            </tr>
            @endforeach
        </table>
       
            <button type="submit" class="btn btn-sm btn-outline-info">Place Order</button> |
        </form>
        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="window.location='{{route('products.list')}}'">Back</button> | 
        <a href="{{ route('cart.view') }}" class="btn btn-sm btn-outline-secondary">Refresh</a>
    </div> 
    <script>
        $('#document').ready(function(){
            $('.order-select').change(function(){
                var orderId = $(this).val();
                var rowId = $(this).attr('id').split('_')[2];
                if(orderId !== "select"){
                    $.ajax({
                        url: "{{route('cart.details')}}",
                        type: "GET",
                        data: {order_id: orderId},
                        success: function(response){
                            if(response.success){
                                $('#email_' + rowId).val(response.email);
                                $('#phone_' + rowId).val(response.phone);
                                $('#streetaddress_' + rowId).val(response.streetaddress);
                                $('#pin_' + rowId).val(response.pin);
                                $('#city_' + rowId).val(response.city);

                                $('#email_div_' + rowId).show();
                                $('#phone_div_' + rowId).show();
                                $('#streetaddress_div_' + rowId).show();
                                $('#pin_div_' + rowId).show();
                                $('#city_div_' + rowId).show();
                            }
                        }
                    });
                }else{
                    $('#email_div_' + rowId).hide();
                    $('#phone_div_' + rowId).hide();
                    $('#streetaddress_div_' + rowId).hide();
                    $('#pin_div_' + rowId).hide();
                    $('#city_div_' + rowId).hide();
                }
            });
        });
     </script>   
    <script>
        function increment(id){
            $('#cart_update_error').text('');
            $('#cart_update_error').text('');

            let currentQuantity = parseInt($(`#quantity-${id}`).val());
            if(currentQuantity == 10){
                $('#cart_update_error').text('Maximum order quantity is 10');
                $('#cart_update_error').show();
                $('#cart_update_success').hide();
            } else{
                currentQuantity++;

                let price = parseFloat($(`#price-${id}`).text());
                $(`#quantity-${id}`).val(currentQuantity);
                const updatedTotalPrice = Math.round(price * currentQuantity);
                $(`#total-price-${id}`).text(updatedTotalPrice);
                $('#cart_update_success').text('Cart is updated successfully');
                $('#cart_update_success').show();
                $('#cart_update_error').hide();
            }
        }
        function decrement(id){
            $('#cart_update_error').text('');
            $('#cart_update_success').text('');
            
            let currentQuantity = parseInt($(`#quantity-${id}`).val());
            if (currentQuantity == 1) {
                $('#cart_update_error').text('Minimum order quantity is 1');
                $('#cart_update_error').show();
                $('#cart_update_success').hide();
            } else {
                currentQuantity--;

                let price = parseFloat($(`#price-${id}`).text()); 
                $(`#quantity-${id}`).val(currentQuantity);
                const updatedTotalPrice = Math.round(price * currentQuantity);
                $(`#total-price-${id}`).text(updatedTotalPrice);
                $('#cart_update_success').text('Cart is updated successfully');
                $('#cart_update_success').show();
                $('#cart_update_error').hide();
            }
        }

    </script>
</body>
</html>