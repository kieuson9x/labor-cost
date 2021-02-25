@extends('base')
@section('customCSS')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" rel="stylesheet">
@endsection
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Báo cáo ngân sách lương</h1>

        <form method="GET" action="{{ route('reports.salary')}}">
            @method('GET')
            @csrf
            <div class="form-group col-md-6 col-sm-12">
                <label for="first_name">Chọn năm</label>
                <div class="input-group">
                    <select id="year-selection" class="form-control custom-select" style="width: 150px;" id="year"
                        name="year">
                        @foreach([2021, 2022, 2033] as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="first_name">Phòng Ban</label>
                <div class="input-group">
                    <select id="department_selection" class="form-control custom-select" style="width: 150px;" id="year"
                        name="dêpartment_id">
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
        <div class="chart-container" style="position: relative; height:600px; width:800px">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>

    </div>
</div>
@endsection
@section('customScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(function () {
        var ctx = document.getElementById('myChart');
        var barChartData = {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ],
            datasets: [{
                label: 'Kế hoạch',
                backgroundColor: 'blue',
                borderColor: 'white',
                borderWidth: 1,
                data: [
                    2,
                    2,
                    3,
                    4,
                    4,
                    5,
                    6,
                    5,
                    6,
                    5,
                    6,
                    3
                ]
            }, {
                label: 'Thực tế',
                backgroundColor: 'red',
                borderColor: 'white',
                borderWidth: 1,
                data: [
                    2,
                    2,
                    3,
                    4,
                    1,
                    3,
                    3,
                    3,
                    3,
                    3,
                    3,
                    3,
                ]
            }]

        };

        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });

</script>

@endsection
