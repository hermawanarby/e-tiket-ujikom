<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EZGO Travel</title>
    <link rel="icon" href="{{ url('images/logo.png') }}" sizes="16x16" type="image/png">

    <!-- Bootstrap core CSS-->
    <link href="{{ url('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{ url('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ url('css/sb-admin.css') }}" rel="stylesheet">

    @stack('css')

  </head>

  <body>

    <div class="container-fluid mt-2 mb-2">
      <img src="{{url('images/logo.png')}}" height="70">
      <hr class="bg-secondary mb-1">
      <small>
        455 Moun Eden Road, Moun Eden, Aucland.
        <span class="fa fa-aw fa-phone"></span> : +62-889-889-456-001,
        <span class="fa fa-aw fa-mail-bulk"> : ezgotravel@gmail.com</span>
      </small>
      <hr class="bg-secondary mt-1">
      @yield('content')
    </div>

  </body>

</html>
