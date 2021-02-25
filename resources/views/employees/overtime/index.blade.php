@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Bảng tăng ca</h1>

        <form>
            <div class="form-group row">
                <label for="full_name" class="col-sm-2 col-form-label">Họ tên nhân viên</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="full_name"
                        value="{{$employee->full_name}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="deparment" class="col-sm-2 col-form-label">Bộ phận</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="deparment"
                        value="{{$employee->department->name}}">
                </div>
            </div>
        </form>

        <form method="GET" action="{{ route('employees.overtimes.index', ['employeeId' => $employeeId]) }}">
            @method('GET')
            @csrf
            <div class="form-group col-sm-3">
                <label for="first_name">Chọn năm</label>
                <div class="input-group">
                    <select id="year-selection" class="form-control custom-select" style="width: 150px;" id="year" name="year">
                        @foreach([2021, 2022, 2033] as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>


            </div>

        </form>

        <table class="table table-striped" data-toggle="table" data-editable="true" id="table_overtimes">
            <thead>
                <tr>
                    <th>Nội dung</th>
                    <th data-editable="true">Tháng 1</th>
                    <th data-editable="true">Tháng 2</th>
                    <th data-editable="true">Tháng 3</th>
                    <th data-editable="true">Tháng 4</th>
                    <th data-editable="true">Tháng 5</th>
                    <th data-editable="true">Tháng 6</th>
                    <th data-editable="true">Tháng 7</th>
                    <th data-editable="true">Tháng 8</th>
                    <th data-editable="true">Tháng 9</th>
                    <th data-editable="true">Tháng 10</th>
                    <th data-editable="true">Tháng 11</th>
                    <th data-editable="true">Tháng 12</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Làm thêm ngày thường</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left">
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'weekdays', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Làm thêm ngày CN</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'sunday', 0) }}
                        </td>
                        @endfor
                <tr>
                    <td>Làm thêm ngày lễ</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'holiday', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Làm việc ban đêm</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'night', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Làm thêm ban đêm ngày thường</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'weekdays_night', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Làm thêm ban đêm ngày CN</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'sunday_night', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Làm thêm ban đêm ngày lễ</td>
                    @for ($i = 0; $i < 12; $i++) <td>
                        {{ data_get($overtimes->where('month', $i + 1)->first(), 'holiday_night', 0) }}
                        </td>
                        @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('customScript')
<script>
    $(function () {
        $('#table_overtimes').bootstrapTable({
            resizable: true,
        });

        $('#table_overtimes').on('editable-save.bs.table', function (e, field, row, oldValue) {
            var url = "{{route('employees.overtimes.update', ['employeeId' => $employeeId])}}";
            $.ajax({
                data: {
                    'action': 'update',
                    'month': field,
                    'year': "{{$year}}",
                    'type': row["0"],
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
                console.log(response);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
            });
        });
    });

</script>
@endsection
