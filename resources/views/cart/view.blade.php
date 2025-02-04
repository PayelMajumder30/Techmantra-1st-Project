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
        <table class="modal-header">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
            @foreach($cart as $id => $item)
            <tr>
                <td>{{ $item['name']}}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary decrement" data-id="{{ $id }}">-</button>
                    <input type="number" class="form-control text-center quantity" data-id="{{ $id }}" value="{{ $item['quantity'] }}" min="1" disabled>
                    <button class="btn btn-sm btn-outline-secondary increment" data-id="{{ $id }}">+</button>
                </td>
                <td class="price">{{$item['price']}}</td>
                <td class="total-price" data-id="{{$id}}">{{$item['total_price']}}</td>
            </tr>
            @endforeach
        </table>
    </div> 
    
    {{-- <script>
       document.querySelectorAll('.increment, .decrement').forEach(button=> {
        button.addEvenetListner('click', function(){
            let id = this.dataset.id;
            let quantityInput = document.querySelector(`.quantity[data-id]="${id}"`);
            let price = parseFloat(document.querySelector(`.price[data-id]="${id}"`).innerText);
            let totalPriceElement = document.querySelector(`.total-price[data-id]="${id}"`);
            let currentQuantity = parseInt(quantityInput.value);
            if(this.classList.contains('increment')){
                currentQuantity++;   
            }else if(this.classList.contains('decrement') && currentQuantity >1){
                currentQuantity--;
            }
            quantityInput.value = currentQuantity;
            totalPriceElement.innerText = (price * currentQuantity.toFixed(2));
        });
       });
    </script> --}}
    <script>
       $(document).ready(function () {
          $('.increment').on("click",function(){
            let id = $(this).data('id');  
            let quantityInput = $(`.quantity[data-id="${id}"]`);  
            let price = parseFloat($(`.price[data-id="${id}"]`).text());  
            alert('')
            let totalPriceElement = $(`.total-price[data-id="${id}"]`);  

            let currentQuantity = parseInt(quantityInput.val());  
            currentQuantity++;  
            quantityInput.val(currentQuantity);  
            // totalPriceElement.text(Math.round(price * currentQuantity)); 
          });

          $('.decrement').on("click",function(){
            let id = $(this).data('id');  
            let quantityInput = $(`.quantity[data-id="${id}"]`);  
            let price = parseFloat($(`.price[data-id="${id}"]`).text());  
            let totalPriceElement = $(`.total-price[data-id="${id}"]`);  

            let currentQuantity = parseInt(quantityInput.val());  
            if (currentQuantity > 1) {  
                currentQuantity--;  
                quantityInput.val(currentQuantity);  
                totalPriceElement.text((price * currentQuantity).toFixed(2));  
            }
          });
       });
    </script>
</body>
</html>