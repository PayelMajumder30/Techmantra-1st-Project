@extends('layouts.admin-layout')
@section('title', 'Update category')
@section('heading', 'Update category')

@section('content')

<div class="container">
    @if(Session::has('success'))
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
    <form action="{{route('categories.update', ['id' => $category->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card m-3 p-3">   
            <div class="form-group">
                Tittle: <input type="text" value="<?php echo $category['title'] ?>" name="edtitle" id="edtitle" class="form-control">
            </div>
            <div class="form-group">
                Image:
                <img src="{{asset($category['image'])}}" alt="no image" tittle="<?php echo $category['title'] ?>'s pic" height="120px" width="120px" class="img-thumbnail">
                <input type="hidden" name="previous_image" value="<?php echo $category['image']?>">
                <input type="file" name="edimg" id="edimg" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>   
        </div>
    </form>
@stop
</div>
        

