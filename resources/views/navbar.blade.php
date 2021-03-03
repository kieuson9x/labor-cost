<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/employees">
                    <i class="material-icons" style="font-size: 13px">people</i>
                    Nhân viên
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('departments')) ? 'active' : '' }}" href="/departments">
                    <i class="material-icons" style="font-size: 13px">doorbell</i>
                    Bộ phận
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('working_days*')) ? 'active' : '' }}" href="/working-days">
                    <i class="material-icons" style="font-size: 13px">calendar_today</i>
                    Lịch làm việc năm
                </a>
            </li>

            <div class="dropdown-divider"></div>


            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('departments.budget_plans*')) ? 'active' : '' }}"
                    href="/departments/budget-plans">
                    <i class="material-icons" style="font-size: 13px">document_scanner</i>
                    Nhập kế hoạch ngân sách
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('product_plans*')) ? 'active' : '' }}" href="/departments/budgets">
                    <i class="material-icons" style="font-size: 13px">account_balance</i>
                    Nhập luỹ kế thực tế
                </a>
            </li>

            <div class="dropdown-divider"></div>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('products*')) ? 'active' : '' }}" href="/products">
                    <i class="material-icons" style="font-size: 13px">production_quantity_limits</i>
                    Sản phẩm
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('product_plans*')) ? 'active' : '' }}" href="/departments/product-plans">
                    <i class="material-icons" style="font-size: 13px">document_scanner</i>
                    Kế hoạch sản xuất sẩn phẩm theo phòng ban
                </a>
            </li>

            <div class="dropdown-divider"></div>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('reports.salary*')) ? 'active' : '' }}"
                    href="/reports/salary">
                    <i class="material-icons" style="font-size: 13px">bar_chart</i>
                    Biểu đồ lương
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->routeIs('reports.labor-cost*')) ? 'active' : '' }}"
                    href="/reports/labor-cost">
                    <i class="material-icons" style="font-size: 13px">bar_chart</i>
                    Biểu đồ tính nhân công
                </a>
            </li>
        </ul>
    </div>
</nav>
