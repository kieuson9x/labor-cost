<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labor Cost</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/toasty.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/css/bootstrap-editable.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"  type="text/css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">

    @yield('customCSS')
</head>

<body>
    @include('navbar')
    <div class="container-fluid page-body-wrapper">
        {{-- Nav bar --}}
        @include('sidebar')

        {{-- Main  --}}
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('main')
          </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/editable/bootstrap-table-editable.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/toasty.min.js') }}"></script>
    <script>
        $(function () {
            var interval = setInterval(function () {
                if (!dayjs) {
                    clearInterval(interval);
                }

                $('#date-time').html(dayjs().format('DD/MM/YYYY --- HH:mm:ss'));
            }, 1000);

            $('.navbar-toggler').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            if (window.matchMedia('(max-width: 991px)').matches) {
                console.log("Add");
                $('.sidebar').addClass('sidebar-offcanvas');
            } else {
                $('.sidebar').removeClass('sidebar-offcanvas');
            }
        })

        $(window).resize(function() {
            if (window.matchMedia('(max-width: 991px)').matches) {
                $('.sidebar').addClass('sidebar-offcanvas');
            } else {
                $('.sidebar').removeClass('sidebar-offcanvas');
            }
        });



    </script>
    @yield('customScript')
</body>

</html>
