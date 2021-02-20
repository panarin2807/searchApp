@extends('layouts.report')

@section('title')
    Report
@endsection

@section('header')
    จำนวนเล่มโครงงานแบ่งตามหมวดหมู่
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading my-2">รายงานจำนวนเล่มโครงงานในแต่ละหมวดหมู่</div>
                    <div class="col-lg-12">
                        <canvas id="report" class="rounded shadow"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var config = JSON.parse('<?php echo $chart; ?>');
        var barChartData = {
            labels: config.labels,
            datasets: [{
                label: 'จำนวนโครงงานต่อหมวดหมู่ ',
                backgroundColor: config.colours,
                data: config.dataset
            }]
        };

        $(document).ready(function() {
            console.log(config.dataset);
            var ctx = document.getElementById('report').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: barChartData,
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value % 1 === 0) {
                                        return value
                                    }
                                }
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'จำนวนโครงงาน (เล่ม)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'หมวดหมู่'
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            //fontColor: '#122C4B',
                            // fontFamily: "'DB'",
                            position: 'bottom',
                            padding: 25,
                            boxWidth: 25,
                            fontSize: 14,

                        }
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 0,
                            bottom: 10
                        }
                    }
                }
            });
        })

    </script>
@endpush
