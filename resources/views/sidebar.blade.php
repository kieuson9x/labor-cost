<nav class="sidebar active" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/">
                <i class="material-icons" style="font-size: 13px">
                    dashboard
                </i>
                Trang chủ
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/employees">
                <i class="material-icons" style="font-size: 13px">people</i>
                Nhân viên
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#departments" aria-expanded="false"
                aria-controls="product_plans">
                <i class="material-icons" style="font-size: 13px">doorbell</i>
                <span class="menu-title">Bộ phận</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="departments">
                <ul class="nav flex-column sub-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="/departments/1" departmentId="1">Ban Giám đốc</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="/departments/2" departmentId="2">Phòng Hành
                                chính-Nhân sự</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/3" departmentId="3">Phòng Tài
                                chính-Kế toán</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/4" departmentId="4">Kế hoạch điều độ
                                nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/5" departmentId="5">Phòng Kỹ thuật
                                nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/6" departmentId="6">Phòng kho linh
                                kiện vật tư sản xuất</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/7" departmentId="7">Phòng Cung ứng
                                Nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/8" departmentId="8">Phòng QC Nhà
                                máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/9" departmentId="9">Phân xưởng
                                BNN</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/10" departmentId="10">Phân xưởng
                                RO</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/11" departmentId="11">Phân xưởng
                                Inox</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/12" departmentId="12">Phân xưởng
                                NLMT</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/13" departmentId="13">Phân xưởng Điện
                                lạnh</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/14" departmentId="14">Phân xưởng Bếp
                                Điện từ</a></li>
                    </ul>
                </ul>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('working_days*')) ? 'active' : '' }}" href="/working-days">
                <i class="material-icons" style="font-size: 13px">calendar_today</i>
                Lịch làm việc năm
            </a>
        </li> --}}
        <div class="dropdown-divider"></div>
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('departments.budget_plans*')) ? 'active' : '' }}"
                href="/departments/budget-plans">
                <i class="material-icons" style="font-size: 13px">document_scanner</i>
                Nhập kế hoạch ngân sách
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('departments.budget_plans*')) ? 'active' : '' }}"
                href="/departments/budgets">
                <i class="material-icons" style="font-size: 13px">account_balance</i>
                Nhập chi phí thưc tế ERP
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
            <a class="nav-link" data-toggle="collapse" href="#product_plans" aria-expanded="false"
                aria-controls="product_plans">
                <i class="material-icons" style="font-size: 13px">document_scanner</i>
                <span class="menu-title">Kế hoạch sản xuất sẩn phẩm</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product_plans">
                <ul class="nav flex-column sub-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="/departments/1/product-plans" departmentId="1">Ban Giám đốc</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="/departments/2/product-plans" departmentId="2">Phòng Hành
                                chính-Nhân sự</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/3/product-plans" departmentId="3">Phòng Tài
                                chính-Kế toán</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/4/product-plans" departmentId="4">Kế hoạch điều độ
                                nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/5/product-plans" departmentId="5">Phòng Kỹ thuật
                                nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/6/product-plans" departmentId="6">Phòng kho linh
                                kiện vật tư sản xuất</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/7/product-plans" departmentId="7">Phòng Cung ứng
                                Nhà máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/8/product-plans" departmentId="8">Phòng QC Nhà
                                máy</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/9/product-plans" departmentId="9">Phân xưởng
                                BNN</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/10/product-plans" departmentId="10">Phân xưởng
                                RO</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/11/product-plans" departmentId="11">Phân xưởng
                                Inox</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/12/product-plans" departmentId="12">Phân xưởng
                                NLMT</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/13/product-plans" departmentId="13">Phân xưởng Điện
                                lạnh</a></li>
                        <li class="nav-item"><a class="nav-link" href="/departments/14/product-plans" departmentId="14">Phân xưởng Bếp
                                Điện từ</a></li>
                    </ul>
                </ul>
            </div>
        </li>

        {{-- <div class="dropdown-divider"></div> --}}

        {{-- <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('reports.salary*')) ? 'active' : '' }}" href="/reports/salary">
                <i class="material-icons" style="font-size: 13px">bar_chart</i>
                Biểu đồ lương
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('reports.labor-cost*')) ? 'active' : '' }}"
                href="/reports/labor-cost">
                <i class="material-icons" style="font-size: 13px">bar_chart</i>
                Biểu đồ tính nhân công
            </a>
        </li> --}}
    </ul>
</nav>
