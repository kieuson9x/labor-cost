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

        <table class="table table-striped" id="table_working_days">
            <thead>
                <tr class="tableizer-firstrow">
                    <th>Nội dung</th>
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
                    <td>Lịch tháng</td>
                    @foreach( $workingDays as $item)
                    <td>{{ $item->daysInMonth }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Ngày làm việc thực tế</td>
                    @foreach( $workingDays as $item)
                    <td>{{ $item->working_days }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Nghỉ hằng năm</td>
                    @foreach( $workingDays as $item)
                    <td>{{ $item->annual_days_off }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>nghỉ chiều thứ 7</td>
                    @foreach( $workingDays as $item)
                    <td>{{ $item->saturday_afternoon_day_off }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>nghỉ lễ tết</td>
                    @foreach( $workingDays as $item)
                    <td>{{ $item->holiday }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function () {
        const createdCell = function (cell) {
            let original

            cell.setAttribute('contenteditable', true)
            cell.setAttribute('spellcheck', false)

            cell.addEventListener('focus', function (e) {
                original = e.target.textContent
            })

            cell.addEventListener('blur', function (e) {
                if (original !== e.target.textContent) {
                    const row = table.row(e.target.parentElement)
                    row.invalidate()
                    console.log('Row changed: ', row.data())
                }
            })
        }

        table = $('#table_working_days').DataTable({
            responsive: true,
            columnDefs: [{
                targets: '_all',
                createdCell: createdCell
            }],
            sort: false,
            paging: false,
            searching: false,
        })
    });

</script>
@endsection