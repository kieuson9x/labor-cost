@extends('base')
@section('customCSS')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" rel="stylesheet">
@endsection
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Biểu đồ lương</h1>

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
                    <i class="material-icons">filter_alt</i>
                    Lọc
                </button>
            </div>

        </form>

        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="chart-container" style="">
                    <canvas id="monthly_chart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="chart-container" style="">
                    <canvas id="total_chart"></canvas>
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

        const LUY_KE_KH = {
            "label":"Luỹ kế theo kế hoạch",
            "name": "Luỹ kế theo kế hoạch",
            "color": "#ff8a5b"
        };
        const LUY_KE_LUONG_KH_SX = {
            "label":"Luỹ kế lương theo kế hoạch sản xuất",
            "name": "Luỹ kế lương theo kế hoạch sản xuất",
            "color": "#395b50",
            "passColor": "green",
            "failColor": "red"
        };
        const CHI_PHI_ERP = {
            "label":"Chi phí thực tế ERP",
            "name": "Chi phí thực tế ERP",
            "color": "#5c9ead",
            "passColor": "green",
            "failColor": "red"
        };

        var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
            'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        var barchartTotal = {
            labels: ['Tổng Ngân sách Năm'],
            datasets: [{
                    label: LUY_KE_KH.label,
                    backgroundColor: LUY_KE_KH.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: [Math.round(budgetData['Tổng'][LUY_KE_KH.name])]
                }, {
                    label: LUY_KE_LUONG_KH_SX.label,
                    backgroundColor: LUY_KE_LUONG_KH_SX.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: [Math.round(budgetData['Tổng'][LUY_KE_LUONG_KH_SX.name])]
                },
                {
                    label: CHI_PHI_ERP.label,
                    backgroundColor: CHI_PHI_ERP.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: [Math.round(budgetData['Tổng'][CHI_PHI_ERP.name])]
                }
            ]
        }
        var barChartDataMonthly = {
            labels: labels,
            datasets: [{
                    label: LUY_KE_KH.label,
                    backgroundColor: LUY_KE_KH.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: labels.map(item => {
                        return Math.round(budgetData[item][LUY_KE_KH.name]);
                    })
                }, {
                    label: LUY_KE_LUONG_KH_SX.label,
                    backgroundColor: LUY_KE_LUONG_KH_SX.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: labels.map(item => {
                        return Math.round(budgetData[item][
                            LUY_KE_LUONG_KH_SX.name
                        ]);
                    })
                },
                {
                    label: CHI_PHI_ERP.label,
                    backgroundColor: CHI_PHI_ERP.color,
                    borderColor: 'white',
                    borderWidth: 1,
                    data: labels.map(item => {
                        return Math.round(budgetData[item][CHI_PHI_ERP.name]);
                    }),
                },
            ]

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
            options: {
                ...globalOptions,
                title: {
                    display: true,
                    text: 'Biểu đồ theo tháng'
                },
                animation: {
                    onComplete: function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        var scales = chartInstance.scales;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.font = "600 20px Roboto";
                        ctx.fillStyle = "red";
                        const datasets = this.data.datasets;

                        datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);

                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];


                                var budgetPlan = datasets[0].data[index];
                                var budget = datasets[1].data[index];
                                var budgetErp = datasets[2].data[index];

                                var compariableActualBudget = budgetErp === 0 ?
                                    budget : budgetErp;
                                var compariableActualBudgetIndex = budgetErp === 0 ?
                                    1 : 2;

                                var view = bar._view;
                                var x = view.x;
                                var yScale = scales['y-axis-0'];
                                var y = yScale.bottom - 30;
                                ctx.save();
                                ctx.translate(view.x, y);

                                ctx.rotate(-0.5 * Math.PI);

                                if (compariableActualBudget > budgetPlan) {
                                    if (budgetErp === 0) {
                                        if (bar._model.datasetLabel ===
                                            LUY_KE_LUONG_KH_SX.label) {
                                            ctx.fillStyle = LUY_KE_LUONG_KH_SX.failColor;
                                            ctx.fillText("Vượt", 0, 0);
                                        }
                                    } else {
                                        if (bar._model.datasetLabel ===
                                            CHI_PHI_ERP.label) {
                                            ctx.fillStyle = CHI_PHI_ERP.failColor;
                                            ctx.fillText("Vượt", 0, 0);

                                        }
                                    }

                                } else {
                                    if (budgetErp === 0) {
                                        if (bar._model.datasetLabel ===
                                            LUY_KE_LUONG_KH_SX.label) {
                                            ctx.fillStyle = LUY_KE_LUONG_KH_SX.passColor;
                                            ctx.fillText("OK", 0, 0);
                                        }
                                    } else {
                                        if (bar._model.datasetLabel ===
                                            CHI_PHI_ERP.label) {
                                            ctx.fillStyle = CHI_PHI_ERP.passColor;
                                            ctx.fillText("OK", 0, 0);
                                        }
                                    }
                                }

                                ctx.restore();
                            });
                        });
                    }
                }
            }
        });

        var myBarChartForTotal = new Chart(totalChartCtx, {
            type: 'bar',
            data: barchartTotal,
            options: {
                ...globalOptions,
                title: {
                    display: true,
                    text: 'Biểu đồ tổng theo năm'
                }
            }
        });
    });

</script>

@endsection
