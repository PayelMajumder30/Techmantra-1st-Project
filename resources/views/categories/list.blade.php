
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('includes.header')
    @extends('includes.navbar')
    @section('content')
    @if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
    @elseif(Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif

    <div class="d-flex justify-content-end">
        <a href="{{ route('categories.add')}}" class="btn btn-sm btn-primary">Add Category</a> 
    </div>       
    <div class="container">
        <div class="form-group">       
        <div class="card m-4 p-4">
            <table class="table table-hover">
                <form action="{{route('categories.list')}}" method="GET">
                    <header class="modal-header">
                        <h3>Category List</h3>
                    </header>
                    <div class="form-group">
                        <tr>
                            <th>Tittle</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach($categories as $category)
                        <tr>    
                            <td>{{$category->title}}</td>
                            <td>
                                <img src="{{asset($category->image)}}" alt="No image" title="<?php echo $category['image']?>'s pic" height="120px" width="120px" class="img-thumbnail">
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-sm btn-outline-info">Edit</a> | 
                                <form action="{{route('categories.delete', ['id' => $category->id])}}" method="POST" >
                                    @csrf 
                                    @method('DELETE') 
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>   
                                </form>      
                            </td> 
                        </tr>
                        @endforeach 
                        <div class="form-group">
                            <a href="{{ route('categories.list') }}" class="btn btn-sm btn-outline-primary">Refesh</a>
                            <a href="{{route('categories.add')}}" class="btn btn-sm btn-outline-secondary">Back</a>
                        </div>
                    </div>                     
                </form>             
            </table>
            {{ $categories->links() }}
        </div>
    </div>
   @endsection 
</body>
</html>