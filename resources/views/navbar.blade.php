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
          <a class="nav-link {{ (request()->routeIs('reports.salary*')) ? 'active' : '' }}" href="/reports/salary">
            <i class="fas fa-stopwatch-20"></i>
            Báo cáo lương
          </a>
        </li>
      </ul>
    </div>
  </nav>