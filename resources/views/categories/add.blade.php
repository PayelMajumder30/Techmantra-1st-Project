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
        <div class="card m-5 p-5">
            <header class="modal-header">
                <h3>Add Category</h3>
            </header>
            <form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    Tittle: <input type="text" name="title" id="title" class="form-control">
                    @error('title')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    Category Image: <input type="file" name="image" id="image" onchange="loadImage(event)" class="form-control">
                </div>
                @error('image')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <div class="form-group">
                    <button id="b1" class="btn btn-sm btn-outline-info" type="submit">Submit</button>
                    <a href="{{route('products.list')}}" class="btn btn-sm btn-outline-success">Back</a>
                    <a href="{{ route('categories.add') }}" class="btn btn-sm btn-outline-primary">Refresh</a>
                </div>
            </form>
           
        </div>
    </div>
</body>
</html>