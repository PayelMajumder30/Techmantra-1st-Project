<!doctype html>
<html>
<head>
   @include('includes.head')
</head>
<body>
<div class="container-fluid">
   <header class="modal-header">
       @include('includes.header')
   </header>
   <div>
        @yield('content')
   </div>

   @yield('page-script')
</div>
</body>
</html>