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
    <div class="container">
        <div class="card m-3 p-3">
            <header class="modal-header">
                <h3>Add Product</h3>
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

            <form method="POST"  action="{{ route('products.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    Name: <input type="text" value="{{old('name')}}" name="name" id="name" class="form-control">
                    <div id="nameError"></div>
                </div>
                <div class="form-group">
                    Quantity: <input type="number" value="{{old('quantity')}}" name="quantity" id="quantity"  class="form-control">
                </div>
                <div class="form-group">
                    Price: <input type="number" value="{{old('price')}}" name="price" id="price"  class="form-control">
                </div>
                <div class="form-group">
                    Category : <select name="category_id" id="category_id" required class="form-control">
                        <option value="select" selected hidden >---Choose a Product ---</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                        
                </select>
                </div>
                <div class="form-group">
                    Product Image:<input type="file" name="image" id="image" onchange="loadImage(event)"  class="form-control">
                    <div id="imgError"></div> <div id="img_prev"></div>
                    <script type="text/javascript">
                        function loadImage(e){
                            console.log(e);
                            var file = event.target.files[0];
                            if(file.type == "image/jpeg"
                                || file.type == "image/jpg"
                                || file.type == "image/png"
                                || file.type == "image/gif"
                            ){
                                console.log("file detected");
                                document.getElementById("img").classList.add("is-valid");
                                document.getElementById("img").classList.remove("is-invalid");
                                document.getElementById("b1").disabled=false;
                                document.getElementById("imgError").innerHTML="";
                                var imageBlob = URL.createObjectURL(file);
                                console.log(imageBlob);
                                document.getElementById("img_prev").innerHTML=`
                                <img src = "${imageBlob}" height = "150px" width = "150px"/>`;
                                
                            }else{
                                console.log("invalid image");
                                document.getElementById("img").classList.add("is-invalid");
                                document.getElementById("img").classList.remove("is-valid");
                                document.getElementById("b1").disabled=true;
                                document.getElementById("imgError").innerHTML="<span class='text-danger'>Invalid image</span>";
                            }
                        }
                    </script>
                </div>
             
                <div class="form-group">
                    <button id="b1" class="btn btn-sm btn-outline-primary" type="submit">Add</button>
                    <a href="{{route('products.list')}}" class="btn btn-sm btn-outline-success">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>