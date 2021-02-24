<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Labor Cost</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <link href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Kangaroo</a>
  </nav>
  <div class="container-fluid">
    <div class="row">

      {{-- Nav bar --}}
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="/">
                <i class="fas fa-house-user"></i>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/employees">
                <i class="fas fa-users"></i>
                Nhân viên
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ (request()->routeIs('working_days*')) ? 'active' : '' }}" href="/working-days">
                <i class="far fa-calendar-alt"></i>
                Lịch làm việc năm
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ (request()->routeIs('overtimes*')) ? 'active' : '' }}" href="/overtimes">
                <i class="fas fa-stopwatch-20"></i>
                Nhập số giờ làm thêm
              </a>
            </li>
          </ul>
        </div>
      </nav>

      {{-- Main  --}}
      <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        @yield('main')
      </main>
    </div>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('customScript')
</body>

</html>