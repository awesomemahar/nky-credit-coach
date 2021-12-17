@extends('layouts.client.master')

@section('content')
    <!-- Header -->
    <?php
    if($theme == 'bg-info'){
        $c_color = 'bg-gradient-red';
    }
    else{
        $c_color = 'bg-yellow';
    }
    ?>
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h4 text-white d-inline-block mb-5">Dashboard</h6>



                <!-- Card stats -->
                <div class="row">

                    <div class="col-xl-6 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Letters</h5>
                                        <span class="h2 font-weight-bold mb-0">{{auth()->user()->letters->count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                                class="icon icon-shape {{$c_color}} text-white rounded-circle shadow">
                                            <i class="ni ni-email-83"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                    <span class="text-nowrap">Since I Joined</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Disputes</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ auth()->user()->disputes->count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                                class="icon icon-shape {{$c_color}} text-white rounded-circle shadow">
                                            <i class="fas fa-file-archive"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                    <span class="text-nowrap">Since I Joined</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Disputes</h6>
                                <h5 class="h3 mb-0">Total Disputes</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="chart-bars2" class="chart-canvas chartjs-render-monitor" style="display: block; width: 356px; height: 350px;" width="356" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        var BarsChart = (function() {

            //
            // Variables
            //

            var $chart = $('#chart-bars2');


            //
            // Methods
            //
            // Init chart
            function initChart($chart) {
                var months = new Array();
                var vals = new Array();
                <?php foreach($months as $months){ ?>
                months.push('<?php echo $months; ?>');
                <?php } ?>


                <?php foreach($monthly_vals as $monthly_val){ ?>
                vals.push('<?php echo $monthly_val; ?>');
                <?php } ?>
                // Create chart
                var ordersChart = new Chart($chart, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Account Disputes',
                            data: vals
                        }]
                    }
                });

                // Save to jQuery object
                $chart.data('chart', ordersChart);
            }


            // Init chart
            if ($chart.length) {
                initChart($chart);
            }

        })();
    </script>
@endsection
