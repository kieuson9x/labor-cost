@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Kế hoạch lương</h1>
        <form method="GET" action="{{ route('departments.budget_plans.index') }}">
            @method('GET')
            @csrf
            <div class="form-group row">
                <label for="year" class="col-xs-3 col-form-label mr-2">Năm</label>
                <div class="col-xs-9">
                    <select id="year-selection" class="form-control" id="year" name="year">
                        @foreach([2021, 2022, 2033] as $item)
                        <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>{{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-xs-3 col-xs-9">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </form>

        <table class="table table-striped" data-toggle="table" id="table_budget_plans" data-editable="true">
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
                @foreach ($departmentOptions as $department)
                    <tr>
                        <td>{{$department['title']}}</td>
                        @for ($i = 0; $i < 12; $i++) <td data-halign="center" id="{{$department['value']}}">
                            {{ number_to_VND(data_get($budgetPlans->where('month', $i + 1)->where('department_id', $department['value'])->first(), 'amount', 0)) }}
                            </td>
                            @endfor
                    </tr>
                @endforeach

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

        $('#table_budget_plans').bootstrapTable({
            resizable: true,
        });

        $('#table_budget_plans').on('editable-save.bs.table', function (e, field, row, oldValue) {
            var url = "{{route('departments.budget_plans.update')}}";
                var departmentId = row['_1_id'];
                $.ajax({
                data: {
                    'action': 'update',
                    'month': field,
                    'year': "{{$year}}",
                    'department_id': departmentId,
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