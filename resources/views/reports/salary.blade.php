@extends('base')
@section('customCSS')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" rel="stylesheet">
@endsection
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Báo cáo ngân sách lương</h1>

        <form method="GET" action="{{ route('reports.salary')}}" class="form-horizontal">
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

                <label for="department_id" class="col-xs-2 col-form-label mr-2">Bộ phận</label>
                <div class="col-xs-4">
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
                    <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                        <i
                            class="material-icons">filter_alt</i>
                        Lọc
                    </button>
            </div>

        </form>

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="chart-container" style="">
                    <canvas id="total_chart"></canvas>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="chart-container" style="">
                    <canvas id="monthly_chart"></canvas>
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
        var totalChartCtx = document.getElementById('total_chart');
        var monthlyChartCtx = document.getElementById('monthly_chart');

        var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
            'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        var barchartTotal = {
            labels: ['Tổng Ngân sách'],
            datasets: [{
                label: 'Kế hoạch',
                backgroundColor: 'blue',
                borderColor: 'white',
                borderWidth: 1,
                data: [Math.round(budgetData['Tổng']['Kế hoạch'])]
            }, {
                label: 'Thực tế',
                backgroundColor: 'red',
                borderColor: 'white',
                borderWidth: 1,
                data: [Math.round(budgetData['Tổng']['Thực tế'])]
            }]
        }

        var barChartDataMonthly = {
            labels: labels,
            datasets: [{
                label: 'Kế hoạch',
                backgroundColor: 'blue',
                borderColor: 'white',
                borderWidth: 1,
                data: labels.map(item => {
                    return Math.round(budgetData[item]['Kế hoạch']);
                })

            }, {
                label: 'Thực tế',
                backgroundColor: 'red',
                borderColor: 'white',
                borderWidth: 1,
                data: labels.map(item => {
                    return Math.round(budgetData[item]['Thực tế']);
                })
            }]

        };

        var globalOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value, index, values) {
                            if (parseInt(value) >= 1000) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".") + "VND";
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
                            /\B(?=(\d{3})+(?!\d))/g, ".") + 'VND' : t.yLabel + 'VND';
                        return xLabel + ': ' + yLabel;
                    }
                }
            },
        };


        var myBarChartForMonthly = new Chart(monthlyChartCtx, {
            type: 'bar',
            data: barChartDataMonthly,
            options: globalOptions
        });

        var myBarChartForTotal = new Chart(totalChartCtx, {
            type: 'bar',
            data: barchartTotal,
            options: globalOptions
        });
    });

</script>

@endsection
