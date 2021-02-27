<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="/">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/employees">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    Nhân viên
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('working_days*')) ? 'active' : '' }}" href="/working-days">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    Lịch làm việc năm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('departments.budget_plans*')) ? 'active' : '' }}"
                    href="/departments/budget-plans">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    Nhập kế hoạch ngân sách
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('reports.salary*')) ? 'active' : '' }}"
                    href="/reports/salary">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    Báo cáo lương
                </a>
            </li>
        </ul>
    </div>
</nav>
