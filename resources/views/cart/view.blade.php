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
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            @foreach($cart as $id => $item)
            <tr>
                <td>{{ $item['name']}}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary decrement" onclick="decrement({{$id}})">-</button>
                    <input type="number" class="form-control text-center quantity" id="quantity-{{$id}}" value="{{$item['quantity']}}" min="1" disabled>
                    <button class="btn btn-sm btn-outline-secondary increment" onclick="increment({{$id}})">+</button>
                </td>
                <td class="price" id="price-{{$id}}">{{$item['price']}}</td>
                <td class="total-price" id="total-price-{{$id}}">{{$item['total_price']}}</td>
                <td>
                    <form action="{{route('cart.delete', $id)}}" method="POST" onsubmit="return confirm('Are you delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"class="btn btn-sm btn-danger">Delete Item</button>
                    </form>         
                </td>               
            </tr>
            @endforeach
        </table>
        <form action="{{ route('cart.placeOrder') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">Place Order</button>
        </form>
    </div> 
    
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