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
            <div class="form-group row">
                <label for="year" class="col-xs-3 col-form-label mr-2">Năm</label>
                <div class="col-xs-9">
                    <select id="year-selection" class="form-control" id="year" name="year">
                        @foreach([2021, 2022, 2033] as $item)
                        <option value="{{ $item }}"  @if ($item===(int) $year) {{ 'selected' }}
                        @endif >{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="department_id" class="col-xs-3 col-form-label mr-2">Bộ phận</label>
                <div class="col-xs-9">
                    <select class="form-control" id="department_id" name="department_id">
                        @foreach($departmentOptions as $item)
                        <option value="{{ $item['value'] }}" @if ($item['value']===(int) $departmentId) {{ 'selected' }}
                            @endif>
                            {{ $item['title'] }}</option>
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

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="chart-container" style="">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('customScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(function () {
        var budgetData = {!!json_encode($budgetData) !!};
        var ctx = document.getElementById('myChart');

        var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
            'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        var budgetPlanData = labels.map(item => {
            return Math.round(budgetData[item]['Kế hoạch']);;
        });

        var actualBudgetData = labels.map(item => {
            return Math.round(budgetData[item]['Thực tế']);;
        });

        var barChartData = {
            labels: labels,
            datasets: [{
                label: 'Kế hoạch',
                backgroundColor: 'blue',
                borderColor: 'white',
                borderWidth: 1,
                data: budgetPlanData
            }, {
                label: 'Thực tế',
                backgroundColor: 'red',
                borderColor: 'white',
                borderWidth: 1,
                data: actualBudgetData
            }]

        };

        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value, index, values) {
                            if (parseInt(value) >= 1000) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ",") + "VND";
                            } else {
                                return value + "VND";
                            }
                        }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            var yLabel = t.yLabel >= 1000 ? t.yLabel.toString().replace(
                                /\B(?=(\d{3})+(?!\d))/g, ",") + 'VND' : t.yLabel + 'VND';
                            return xLabel + ': ' + yLabel;
                        }
                    }
                },
            }
        });
    });

</script>

@endsection
