<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="card m-3 p-3">
            <header class="modal-header">
                <h3>Admin login</h3>
            </header>
            @if (Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @elseif(Session::has('error'))
              <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif
            <form action="{{ route('admin.login') }}" method="post" >
                @csrf
                <div class="form-group">
                    Email: <input type="text" name="email" id="email">
                    @error('email')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                    Password: <input type="password" name="password" id="password">
                    @error('password')
                     <p class="text-danger small">{{$message}}</p>
                   @enderror
                </div>
                <div class="form-group"><button class="btn btn-sm btn-outline-primary">Login</button></div>
            </form>
        </div>
    </div>

</body>
</html>

</html>