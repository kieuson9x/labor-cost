@extends('base')
@section('main')
<div class="main-content">
    <h1 class="display-3">Kế hoạch sản xuất theo phòng ban</h1>
    <form method="GET" action="{{ route('departments.product_plans.index') }}" class="form-horizontal">
        @method('GET')
        @csrf
        <div class="form-group row">
            <label for="year" class="col-xs-2 col-form-label mr-2">Năm</label>
            <div class="col-xs-4 mr-2">
                <select id="year-selection" class="form-control" id="year" name="year">
                    @foreach([2021, 2022, 2023] as $item)
                    <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>{{ $item }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="department_id" class="col-xs-2 col-form-label mr-2">Bộ phận</label>
            <div class="col-xs-4">
                <select class="form-control" id="department_id0" name="department_id">
                    @foreach($departmentOptions as $item)
                    <option value="{{ $item['value'] }}" @if ($item['value']===(int) $departmentId) {{ 'selected' }}
                        @endif>
                        {{ $item['title'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-xs-6 mr-1">
                <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                    <i class="material-icons">filter_alt</i>
                    Lọc
                </button>
            </div>
            <div class="col-xs-6">
                <a href="#addProductPlanModal" class="btn btn-success flex items-center justify-center"
                    data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm/Cập nhật kế hoạch mới</span></a>
            </div>
        </div>
    </form>

    <table class="table table-striped" data-toggle="table" id="table_product_plans" data-editable="true">
        <thead>
            <tr class="tableizer-firstrow">
                <th>Mã bộ phận</th>
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
                <td>{{data_get($productPlan->first(), 'department.department_code')}}</td>
                <td>{{data_get($productPlan->first(), 'product.product_code')}}</td>
                <td>{{data_get($productPlan->first(), 'product.name')}}</td>


                @for ($i = 0; $i < 12; $i++) <td data-halign="center" id="{{ $productPlan->where('month', $i + 1)->sortBy(['created_at', 'desc'])->first()->id ?? 0 }}">
                    {{ $productPlan->where('month', $i + 1)->sortBy(['created_at', 'desc'])->first()->quantity ?? 0 }}
                    </td>
                    @endfor
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

{{-- Thêm mới --}}
<div id="addProductPlanModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('departments.product_plans.store') }}" class="form-horizontal">
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
                            <option value="{{ $item['value'] }}" @if ($item['value']===(int) $departmentId)
                                {{ 'selected' }} @endif>
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
                            @for($i = 1; $i <=12; $i++)
                                <div class="form-check form-check-inline">
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
</div>

</form>
</div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>

    $(function () {
        var toast = new Toasty();
        $('#table_product_plans').DataTable({
            responsive: true,
            "language": {
                "zeroRecords": "Không có sản phẩm nào được đăng ký cho bộ phận này!",
            }
        });

        $('#table_product_plans').on('editable-save.bs.table', function (e, field, row, oldValue) {
            var url = "{{route('departments.product_plans.update')}}";
            const productPlanId = row[`_${field}_id`];

            $.ajax({
                data: {
                    'action': 'update',
                    'month': field - 2,
                    'year': "{{$year}}",
                    'product_plan_id': productPlanId,
                    'value': row[field]
                },
                dataType: 'json',
                type: "PUT",
                url: url,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }).done(function (response) {
                // If successful
                // show a successful message:
                toast.success("You did something good!");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // If fail
                toast.error(textStatus + ': ' + errorThrown);
            });
        });

        $("select[name*='months']").selectpicker();

    });

</script>

@if(session("success"))
<script type="text/javascript">
  toastr.success("Cập nhật thành công");
<script>
@endif

@endsection
