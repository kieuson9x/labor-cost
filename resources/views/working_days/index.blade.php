@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Working Days</h1>
        <form method="GET" action="{{ route('working_days.index') }}">
            @method('GET')
            @csrf
            <div class="form-group">
                <label for="first_name">Year</label>
                <select class="form-control" id="year" name="year">
                    @foreach([2021, 2022, 2033] as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">View</button>
        </form>

        <table class="table table-striped" data-toggle="table" id="table_working_days" data-editable="true">
            <thead>
                <tr class="tableizer-firstrow">
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
                    <td>Lịch tháng</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-editable={false}>
                        {{ data_get($workingDays->where('month', $i + 1)->first(), 'daysInMonth', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Ngày làm việc thực tế</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-editable="false" >
                        {{ data_get($workingDays->where('month', $i + 1)->first(), 'working_days', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Nghỉ hằng năm</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center">
                        {{ data_get($workingDays->where('month', $i + 1)->first(), 'annual_days_off', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>Nghỉ chiều thứ 7</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center">
                        {{ data_get($workingDays->where('month', $i + 1)->first(), 'saturday_afternoon_day_off', 0) }}
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>nghỉ lễ tết</td>
                    @for ($i = 0; $i < 12; $i++) <td data-halign="center">
                        {{ data_get($workingDays->where('month', $i + 1)->first(), 'holiday', 0) }}
                        </td>
                        @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
    $(function () {
        var toast = new Toasty();

        // $('#table_working_days').bootstrapTable({
        //     resizable: true,
        // });

        $('#table_working_days').on('editable-save.bs.table', function (e, field, row, oldValue) {
            var url = "{{route('working_days.update')}}";
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
                // show a successful message:
                toast.success("You did something good!");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // If fail
                toast.error(textStatus + ': ' + errorThrown);
            });
        });
    });

</script>

@endsection
