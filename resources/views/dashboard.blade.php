@extends('base')

@section('main')
<div class="row">
    <div class="col-md-6 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Tổng quan</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard') }}" class="form-horizontal">
                    @method('GET')
                    @csrf
                    <div class="form-group row">
                        <label for="year" class="col-xs-2 col-form-label mr-2">Năm</label>
                        <div class="col-xs-4 mr-2">
                            <select id="year-selection" class="form-control" id="year" name="year">
                                @foreach([2021, 2022, 2023] as $item)
                                <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>
                                    {{ $item }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-4 mr-1">
                            <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                                <i class="material-icons">filter_alt</i>
                                Lọc
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <a href="#addProductPlanModal" class="btn btn-success flex items-center justify-center"
                                data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm/Cập nhật kế hoạch
                                    mới</span></a>
                        </div>
                    </div>

                    <div class="form-group row">

                    </div>
                </form>

                <table class="table table-striped" data-toggle="table" id="table_dashboard_product_plans"
                    data-editable="true">
                    <thead>
                        <tr class="tableizer-firstrow">
                            <th>Phòng</th>
                            <th>Mã hàng</th>
                            <th>Tên hàng</th>
                            <th data-editable="true">KH tháng 01</th>
                            <th data-editable="true">KH tháng 02</th>
                            <th data-editable="true">KH tháng 03</th>
                            <th data-editable="true">KH tháng 04</th>
                            <th data-editable="true">KH tháng 05</th>
                            <th data-editable="true">KH tháng 06</th>
                            <th data-editable="true">KH tháng 07</th>
                            <th data-editable="true">KH tháng 08</th>
                            <th data-editable="true">KH tháng 09</th>
                            <th data-editable="true">KH tháng 10</th>
                            <th data-editable="true">KH tháng 11</th>
                            <th data-editable="true">KH tháng 12</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productPlans as $productPlan)
                        <tr>
                            <td>{{data_get($productPlan->first(), 'department.name')}}</td>
                            <td><a
                                    href="/products/edit/{{data_get($productPlan->first(), 'product.id')}}">{{data_get($productPlan->first(), 'product.product_code')}}</a>
                            </td>
                            <td>{{data_get($productPlan->first(), 'product.name')}}</td>


                            @for ($i = 0; $i < 12; $i++) <td data-halign="center"
                                id="{{ $productPlan->where('month', $i + 1)->sortBy(['created_at', 'desc'])->first()->id ?? 0 }}">
                                {{ $productPlan->where('month', $i + 1)->sortBy(['created_at', 'desc'])->first()->quantity ?? 0 }}
                                </td>
                                @endfor
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="p-4 border-bottom bg-light">
                        <h4 class="card-title mb-0">Bảng đánh giá chi phí</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped" id="table_department_report_cost">
                                <thead>
                                    <tr class="tableizer-firstrow">
                                        <th class="no-sort">Nội dung</th>
                                        <th>Tổng</th>
                                        <th>Tháng 1</th>
                                        <th>Tháng 2</th>
                                        <th>Tháng 3</th>
                                        <th>Tháng 4</th>
                                        <th>Tháng 5</th>
                                        <th>Tháng 6</th>
                                        <th>Tháng 7</th>
                                        <th>Tháng 8</th>
                                        <th>Tháng 9</th>
                                        <th>Tháng 10</th>
                                        <th>Tháng 11</th>
                                        <th>Tháng 12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Luỹ kế theo kế hoạch</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Luỹ kế theo kế hoạch", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Luỹ kế theo kế hoạch", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Luỹ kế lương theo kế hoạch sản xuất</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Luỹ kế lương theo kế hoạch sản xuất", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Luỹ kế lương theo kế hoạch sản xuất", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Chi phí thực tế ERP</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Chi phí thực tế ERP", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Chi phí thực tế ERP")) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Kết quả</td>
                                        <td class="{{data_get($budgetData, "Tổng.Vượt") ? 'overload' : 'normal-green'}}">{{ data_get($budgetData, "Tổng.Vượt") ? "Vượt" : "OK" }}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left" class="{{data_get($budgetData, "Tháng {$i}.Vượt") ? 'overload' : 'normal-green'}}">
                                            {{ data_get($budgetData, "Tháng {$i}.Vượt") ? "Vượt" : "OK" }}
                                            </td>
                                            @endfor
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="col-sm-12 col-md-5">
                                <div class="chart-container" style="">
                                    <canvas id="total_chart"></canvas>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="chart-container" style="">
                                    <canvas id="monthly_chart"></canvas>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="p-4 border-bottom bg-light">
                        <h4 class="card-title mb-0">Bảng chi phí các bộ phận</h4>
                    </div>
                    <div class="card-body">
                        <table class="table" data-toggle="table" id="table_department_report_salary_cost">
                            <thead>
                                <tr class="tableizer-firstrow">
                                    <th>Nội dung</th>
                                    <th>Lũy kế cả năm</th>
                                    <th>Tháng 1</th>
                                    <th>Tháng 2</th>
                                    <th>Tháng 3</th>
                                    <th>Tháng 4</th>
                                    <th>Tháng 5</th>
                                    <th>Tháng 6</th>
                                    <th>Tháng 7</th>
                                    <th>Tháng 8</th>
                                    <th>Tháng 9</th>
                                    <th>Tháng 10</th>
                                    <th>Tháng 11</th>
                                    <th>Tháng 12</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentOptions as $department)
                                    <tr>
                                        <td>{{str_replace('HY_', '', $department['title'])}}</td>
                                        <td data-halign="center">
                                            {{number_to_VND(data_get($salaryCost, "Tổng.{$department['value']}")) }}
                                        </td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" id="{{$department['value']}}">
                                                {{number_to_VND(data_get($salaryCost, "Tháng {$i}.{$department['value']}"))}}
                                            </td>
                                            @endfor
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="p-4 border-bottom bg-light">
                        <h4 class="card-title mb-0">Bảng đánh giá nhân công</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped" id="table_department_report_employee">
                                <thead>
                                    <tr class="tableizer-firstrow">
                                        <th class="no-sort">Nội dung</th>
                                        <th>Tổng</th>
                                        <th>Tháng 1</th>
                                        <th>Tháng 2</th>
                                        <th>Tháng 3</th>
                                        <th>Tháng 4</th>
                                        <th>Tháng 5</th>
                                        <th>Tháng 6</th>
                                        <th>Tháng 7</th>
                                        <th>Tháng 8</th>
                                        <th>Tháng 9</th>
                                        <th>Tháng 10</th>
                                        <th>Tháng 11</th>
                                        <th>Tháng 12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Số nhân công có</td>
                                        <td>{{data_get($laborCostData, "Tổng.Số nhân công có", 0)}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ data_get($laborCostData, "Tháng {$i}.Số nhân công có", 0) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Số nhân công cần</td>
                                        <td>{{round(data_get($laborCostData, "Tổng.Số nhân công cần", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ round(data_get($laborCostData, "Tháng {$i}.Số nhân công cần", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>

                                    <tr>
                                        <td>Kết quả</td>
                                        <td class="{{data_get($laborCostData, "Tổng.Vượt") ? 'overload' : 'normal-green'}}">{{data_get($laborCostData, "Tổng.Vượt") ? 'Vượt' : 'OK'}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left" class="{{data_get($laborCostData, "Tháng {$i}.Vượt") ? 'overload' : 'normal-green'}}">
                                            {{ data_get($laborCostData, "Tháng {$i}.Vượt") ? 'Vượt' : 'OK' }}
                                            </td>
                                            @endfor
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="col-sm-12 col-md-5">
                                <div class="chart-container" style="">
                                    <canvas id="total_chart"></canvas>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="chart-container" style="">
                                    <canvas id="monthly_chart"></canvas>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Thêm mới --}}
<div id="addProductPlanModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dashboard.product_plan.store') }}" class="form-horizontal">
                @method('POST')
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Thêm/cập nhật mới kế hoạch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Bộ phận</label>
                        <select class="form-control" id="department_id_1" name="department_id">
                            @foreach($departmentOptions as $item)
                            <option value="{{ $item['value'] }}">
                                {{ $item['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label>Sản phẩm</label>
                        <select class="form-control" id="product_id" name="product_id">
                            @foreach($productOptions as $item)
                            <option value="{{ $item['value'] }}">
                                {{ $item['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label>Tháng</label>
                        <div class="form-group ">
                            @for($i = 1; $i <=12; $i++) <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="months[]" value="{{$i}}">
                                <label class="form-check-label" for="{{"month_${i}"}}">{{"Tháng {$i}"}}</label>
                        </div>
                        @endfor
                    </div>
                </div>
                <div class="form-group row">
                    <label>Năm</label>
                    <select id="year-selection" class="form-control" id="year" name="year">
                        @foreach([2021, 2022, 2023] as $item)
                        <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>{{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label>Số lượng</label>
                    <input type="text" class="form-control" name="quantity">
                </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Thêm</button>
            <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
        </div>
    </div>
</div>
@endSection

@section('customScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(function () {
        var toast = new Toasty();

        $('#table_dashboard_product_plans').DataTable({
            responsive: true,
            ordering: false,
        });

        $('#table_department_report_cost, #table_department_report_employee, #table_department_report_salary_cost').DataTable({
            responsive: true,
            paging: false,
            ordering: false,
            searching: false,
            info: false
        });


        $('#table_dashboard_product_plans').on('editable-save.bs.table', function (e, field, row, oldValue) {
            const productPlanId = row[`_${field}_id`];
            var url = "/product-plans/" + productPlanId;

            $.ajax({
                data: {
                    'action': 'update',
                    'month': field - 2,
                    'year': "{{$year}}",
                    'product_plan_id': productPlanId,
                    'value': row[field],
                },
                dataType: 'json',
                type: "PUT",
                url: url,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }).done(function (response) {
                location.reload();
                // renderChart(rfgesponse['numberOfEmployeeData'], response['totalNeededTimeData'], response['totalNeededEmployeeData']);
                // If successful
                // show a successful message:
                toast.success("Cập nhật thành công!");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // If fail
                toast.error(textStatus + ': ' + errorThrown);
            });
        });
    });

</script>
@endsection
