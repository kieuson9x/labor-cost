<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Labor Cost</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}"  type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/toasty.min.css') }}"  type="text/css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"  type="text/css" />
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css"  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/css/bootstrap-editable.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" >
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  @yield('customCSS')
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Kangaroo</a>
  </nav>
  <div class="container-fluid">
    <div class="row">
      {{-- Nav bar --}}
      @include('navbar')

      {{-- Main  --}}
      <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        @yield('main')
      </main>
    </div>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/editable/bootstrap-table-editable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <script src="{{ asset('js/toasty.min.js') }}"></script>
  @yield('customScript')
</body>

</html>