@extends('layouts.client.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/tabs.css') }}" type="text/css">
@endsection
@section('content')
    <!-- Header -->
    <?php
    if($theme == 'bg-info'){
        $c_color = 'bg-blue';
    }
    else{
        $c_color = 'btn-yellow';
    }
    ?>
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Credit Wizard</h6>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- tabs -->
        <div class="wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
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

            <div class="nav-slide mt-5">
            </div>
            <input type="radio" name="slider" {{ ($tab=="dashboard")? "checked" : "" }} id="home">
            <input type="radio" name="slider" {{ ($tab=="new_dispute")? "checked" : "" }} id="blog">
            <input type="radio" name="slider" {{ ($tab=="information")? "checked" : "" }} id="code">
            <input type="radio" name="slider" {{ ($tab=="import")? "checked" : "" }} id="help">
            <input type="radio" name="slider" {{ ($tab=="credit_report")? "checked" : "" }} id="about">
            <nav>
                <label for="home" class="home"><i class="fas fa-home"></i><span class="d-none d-sm-none d-md-inline">Dashboard</span></label>
                <label for="blog" class="blog"><i class="fas fa-blog"></i><span class="d-none d-sm-none d-md-inline">New Dispute</span></label>
                <label for="code" class="code"><i class="fas fa-code"></i><span class="d-none d-sm-none d-md-inline">Information</span></label>
                <label for="help" class="help"><i class="far fa-envelope"></i><span class="d-none d-sm-none d-md-inline">Import</span></label>
                <label for="about" class="about"><i class="far fa-user"></i><span class="d-none d-sm-none d-md-inline">Credit Report</span></label>
                <div class="slider"></div>
            </nav>
            <section>
                <div class="content content-1">
                    <!-- Table -->
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-6 mb-3">
                                    <div class="card h-100">
                                        <div class="row h-100">
                                            <div class="col-md-1 p-0 ">
                                                <div
                                                    class="card-header {{$theme}} text-center align-items-center justify-content-center p-0 h-100">
                                                    <p class="rotated-text text-white font-weight-bold">Client</p>
                                                </div>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        {{ ($client->first_name) ? $client->first_name : 'N/A' }}{{ ($client->last_name) ? $client->last_name : 'N/A' }}
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <h5 class="p-0">{{ ($client->phone) ? $client->phone : 'N/A' }} <br>
                                                                <span
                                                                    class="text-info font-10">{{ ($client->email) ? $client->email : 'N/A' }}</span>
                                                            </h5>
                                                            <p>Status : <span class="text-success">Active</span></p>

                                                        </div>
                                                        <div class="col-md-6">
                                                        {{--<h5 class="p-0"><i class="fas fa-bolt text-blue"></i>--}}
                                                        {{--<a href="{{ url('business/credit/module/'.$client->id) }}"> Run--}}
                                                        {{--Credit--}}
                                                        {{--Wizard</a> <br> <span class="font-8 text-center">Order--}}
                                                        {{--reports--}}
                                                        {{--connect--}}
                                                        {{--errors</span>--}}
                                                        {{--</h5>--}}
                                                        <!--        <h5 class="p-0"><i class="ni ni-send text-blue"></i>
                                                                        Send Secure
                                                                        Message <br> <span class="font-8 text-center">Via
                                                                            Client Portal</span> </h5> -->

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-6  mb-3">
                                    <div class="card h-100">
                                        <div class="row h-100">
                                            <div class="col-md-1  p-0 ">
                                                <div
                                                    class="card-header {{$theme}} text-center align-items-center justify-content-center h-100">
                                                    <p class="rotated-text text-white font-weight-bold">Scores</p>
                                                </div>
                                            </div>
                                            <div class="col-md-11"><div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-small">
                                                                <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th class="text-success">TransUnion</th>
                                                                    <th class="text-blue">EXPERIAN</th>
                                                                    <th class="text-danger">EQUIFAX</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    @if(!is_null($report))
                                                                        @if(isset($report->reportInformation))
                                                                            <th>{{ $report->bureauReportInformation(1)->report_date }}</th>
                                                                            <th>{{ $report->bureauReportInformation(1)->credit_score }}</th>
                                                                            <th>{{ $report->bureauReportInformation(2)->credit_score }}</th>
                                                                            <th>{{ $report->bureauReportInformation(3)->credit_score }}</th>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <div
                                                                class="d-flex font-10 justify-content-between align-items-center">
                                                                <p class="font-10">Start Date :
                                                                    @if(!is_null($report))
                                                                        @if(isset($report->reportInformation))
                                                                            <span>{{ $report->bureauReportInformation(1)->report_date }}</span>
                                                                        @endif
                                                                    @endif
                                                                </p>
                                                                <a href="javascript:void(0) ">Add/Edit Scores</a>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-4">
                                                                    <canvas id="chart-bars" class="chart-canvas w-100"></canvas>
                                                                </div> -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-12  mb-3">
                                    <div class="card h-100">
                                        <div class="row h-100">
                                            <div class="col-md-1  p-0 ">
                                                <div
                                                    class="card-header {{$theme}} text-center align-items-center justify-content-center h-100">
                                                    <p class="rotated-text text-white font-weight-bold">Dispute
                                                        Status
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        Dispute Status
                                                    </div>
                                                    <div class="table-responsive" style="max-height:270px;">
                                                        <table
                                                            class="table align-items-center   table-small table-flush table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-success">TransUnion</th>
                                                                <th class="text-blue">EXPERIAN</th>
                                                                <th class="text-danger">EQUIFAX</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @if(!is_null($report))
                                                                @if(isset($report->reportHistory))
                                                                    <tr>
                                                                        <td class="text-success">Positive</td>
                                                                        <th>{{ $report->reportHistory->where('transunion','OK')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('experian','OK')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('equifax','OK')->count() }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-danger">ChargeOff</td>
                                                                        <th>{{ $report->reportHistory->where('transunion','CO')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('experian','CO')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('equifax','CO')->count() }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-danger">Late Payments</td>
                                                                        <th>{{ $report->reportHistory->where('transunion','LP')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('experian','LP')->count() }}</th>
                                                                        <th>{{ $report->reportHistory->where('equifax','LP')->count() }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-blue">In Dispute</td>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesInfo($report->id, 'is_tu') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesInfo($report->id, 'is_exp') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesInfo($report->id, 'is_eqfx') }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-blue">Dispute(ChargeOff)</td>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_tu','collections') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_exp','collections') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_eqfx','collections') }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-blue">Dispute(Late Payments)</td>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_tu','late_payments') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_exp','late_payments') }}</th>
                                                                        <th>{{ \App\Models\BureauReport::getDisputesTypeInfo($report->id, 'is_eqfx','late_payments') }}</th>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="text-center mt-3 d-flex">


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-2">
                    <!-- Table -->
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h4>What do you want to dispute? Click anyone of below? </h4>
                                        <br> <br>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center mb-5">
                                    <a href="{{ route('client.credit.dispute.type',['type'=>'collections']) }}"  class="d-block p-5" style="border: 2px solid #e3e3e3">
                                        <i class="fas fa-file fa-3x text-info mb-2"></i> <br> Charges Off or Collections
                                    </a>
                                </div>
                                <div class="col-md-6 text-center mb-5">

                                    <a href="{{ route('client.credit.dispute.type',['type'=>'late_payments']) }}" class="d-block p-5" style="border: 2px solid #e3e3e3">
                                        <i class="fas fa-clock fa-3x text-info mb-2"></i> <br>  Late Payments
                                    </a>
                                </div>
                                {{--<div class="col-md-4 text-center" style="border: 2px dotted #e3e3e3">--}}
                                {{--<a href="{{ route('business.credit.dispute.type',['id'=>$client->id,'type'=>'inquiries']) }}" class="d-block p-5">--}}
                                {{--Inquiries--}}
                                {{--</a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-3">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="row">
                                @if(!is_null($report) && isset($report->reportInformation))
                                    <?php
                                    $output = array();
                                    $c=1;
                                    foreach($report->reportInformation as $result)
                                    {
                                        $output[$c]['report_date'] = $result['report_date'];
                                        $output[$c]['name'] = $result['name'];
                                        $output[$c]['also_known_as'] = $result['also_known_as'];
                                        $output[$c]['former'] = $result['former'];
                                        $output[$c]['date_of_birth'] = $result['date_of_birth'];
                                        $output[$c]['current_address'] = $result['current_address'];
                                        $output[$c]['previous_address'] = $result['previous_address'];
                                        $output[$c]['employers'] = $result['employers'];
                                        $output[$c]['credit_score'] = $result['credit_score'];
                                        $output[$c]['lender_rank'] = $result['lender_rank'];
                                        $output[$c]['score_scale'] = $result['score_scale'];

                                        $c++;
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <h3 class="text-center mb-3">Personal Information</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped rptable" >
                                                <thead>
                                                <tr class="d-flex text-center">
                                                    <th class="col-3 bg-blue"></th>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                        if($key == 1){
                                                            echo "<th class='col-3 bg-success text-white'>TransUnion</th>";
                                                        }elseif($key == 2){
                                                            echo "<th class='col-3 bg-info text-white'>Experian</th>";

                                                        }elseif($key == 3){
                                                            echo "<th class='col-3 bg-danger text-white'>Equifax</th>";
                                                        }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Report Date:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['report_date']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Credit Score:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['credit_score']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Lender Rank:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['lender_rank']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Score Scale:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['score_scale']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Name:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['name']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Also Known As:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['also_known_as']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class="col-3 text-right"><strong>Former:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['former']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Date Of Birth:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['date_of_birth']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Current Address(es):</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['current_address']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Previous Address(es):</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['previous_address']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Employers:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['employers']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <?php
                                        $output = array();
                                        $c=1;
                                        foreach($report->reportSummary as $result)
                                        {
                                            $output[$c]['total_accounts'] = $result['total_accounts'];
                                            $output[$c]['open_accounts'] = $result['open_accounts'];
                                            $output[$c]['closed_accounts'] = $result['closed_accounts'];
                                            $output[$c]['delinquent'] = $result['delinquent'];
                                            $output[$c]['derogatory'] = $result['derogatory'];
                                            $output[$c]['collection'] = $result['collection'];
                                            $output[$c]['balances'] = $result['balances'];
                                            $output[$c]['payments'] = $result['payments'];
                                            $output[$c]['public_records'] = $result['public_records'];
                                            $output[$c]['inquiries'] = $result['inquiries'];

                                            $c++;
                                        }
                                        ?>
                                        <div class="table-responsive">
                                            <h3 class="text-center mt-5 mb-3">Summary</h3>
                                            <table class="table table-bordered table-striped rptable" >
                                                <thead>
                                                <tr class="d-flex text-center">
                                                    <th class="col-3 bg-blue"></th>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                        if($key == 1){
                                                            echo "<th class='col-3 bg-success text-white'>TransUnion</th>";
                                                        }elseif($key == 2){
                                                            echo "<th class='col-3 bg-info text-white'>Experian</th>";

                                                        }elseif($key == 3){
                                                            echo "<th class='col-3 bg-danger text-white'>Equifax</th>";
                                                        }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Total Accounts:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['total_accounts']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Open Accounts:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['open_accounts']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Closed Accounts:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['closed_accounts']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Delinquent:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['delinquent']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Derogatory:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['derogatory']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Collection:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['collection']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Balances:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['balances']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Payments:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['payments']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Public Records:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['public_records']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <tr class="text-center d-flex">
                                                    <td class='col-3 text-right'><strong>Inquiries:</strong></td>
                                                    <?php
                                                    foreach ($output as $key => $html)
                                                    {
                                                        echo "<td class='col-3'>".$html['inquiries']."</td>";
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-4">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-6">
                                    <h4>Note: It can take up to 5 Minutes to update the credit report.</h4>
                                    <a href="{{ route('import.report') }}" class="btn btn-primary">Import Report</a>
                                </div>
                                <div class="col-md-6">
                                    <h4>IdentityIQ Credentials:</h4>
                                    <form action="{{ route('credentials.update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="example-text-input"
                                                           class="col-md-4 col-form-label form-control-label">Username(Client):</label>
                                                    <div class="col-md-8">
                                                        <input required class="form-control  @error('iq_username') is-invalid @enderror" type="text"
                                                               id="iq_username" name="iq_username" value="{{ $client->iq_username }}">
                                                        @error('iq_username')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="example-text-input"
                                                           class="col-md-4 col-form-label form-control-label">Password(Client):</label>
                                                    <div class="col-md-8">
                                                        <input required class="form-control  @error('iq_password') is-invalid @enderror" type="password"
                                                               id="iq_password" name="iq_password" value="{{ $client->iq_password }}">
                                                        @error('iq_password')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="example-text-input"
                                                           class="col-md-4 col-form-label form-control-label">Last Four SSN(Client):</label>
                                                    <div class="col-md-8">
                                                        <input required class="form-control  @error('last_four_ssn') is-invalid @enderror" type="number" min="0"
                                                               id="last_four_ssn" name="last_four_ssn" value="{{ $client->last_four_ssn }}" onKeyPress="if(this.value.length==4) return false;" >
                                                        @error('last_four_ssn')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="col-form-label form-control-label" type="checkbox" onclick="showPassword()"> <span> Show Password</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn {{$c_color}} text-white float-right">Update Credentials</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-5">
                    <div class="card mt-5">
                        <div class="card-body">
                            @if(!is_null($report) && isset($report->accountTitles))
                                <div class="row ">
                                    @foreach($report->accountTitles as $title)
                                        <?php
                                        $output = array();
                                        $c=1;
                                        foreach($title->accounts as $result)
                                        {
                                            $output[$c]['account'] = $result['account'];
                                            $output[$c]['account_type'] = $result['account_type'];
                                            $output[$c]['also_known_as'] = $result['also_known_as'];
                                            $output[$c]['account_type_detail'] = $result['account_type_detail'];
                                            $output[$c]['bureau_code'] = $result['bureau_code'];
                                            $output[$c]['account_status'] = $result['account_status'];
                                            $output[$c]['monthly_payment'] = $result['monthly_payment'];
                                            $output[$c]['date_opened'] = $result['date_opened'];
                                            $output[$c]['balance'] = $result['balance'];
                                            $output[$c]['no_of_months'] = $result['no_of_months'];
                                            $output[$c]['high_credit'] = $result['high_credit'];
                                            $output[$c]['credit_limit'] = $result['credit_limit'];
                                            $output[$c]['past_due'] = $result['past_due'];
                                            $output[$c]['payment_status'] = $result['payment_status'];
                                            $output[$c]['last_reported'] = $result['last_reported'];
                                            $output[$c]['comments'] = $result['comments'];
                                            $output[$c]['date_last_active'] = $result['date_last_active'];
                                            $output[$c]['date_of_last_payment'] = $result['date_of_last_payment'];
                                            $c++;
                                        }
                                        ?>
                                        <div class="col-md-12">
                                            <h3 class="text-center mt-3 mb-3">{{ $title->title }}</h3>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped rptable" >
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-3 bg-blue"></th>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                            if($key == 1){
                                                                echo "<th class='col-3 bg-success text-white'>TransUnion</th>";
                                                            }elseif($key == 2){
                                                                echo "<th class='col-3 bg-info text-white'>Experian</th>";

                                                            }elseif($key == 3){
                                                                echo "<th class='col-3 bg-danger text-white'>Equifax</th>";
                                                            }
                                                        ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Account:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['account']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Account Type:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['account_type']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Account Type Detail:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['account_type_detail']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Bureau Code:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['bureau_code']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Account Status:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['account_status']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Monthly Payment:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['monthly_payment']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Date Opened:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['date_opened']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Balance:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['balance']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>No Of Months:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['no_of_months']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>High Credit:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['high_credit']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Credit Limit:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['credit_limit']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Past Due:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['past_due']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Payment Status:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['payment_status']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Last Reported:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['last_reported']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Comments:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['comments']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Date Last Active:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['date_last_active']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center d-flex">
                                                        <td class='col-3 text-right'><strong>Date Of Last Payment:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class='col-3'>".$html['date_of_last_payment']."</td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?php
                                                $output = array();
                                                $c=1;
                                                foreach($title->accountHistories as $result)
                                                {
                                                    $output[$c]['month'] = $result['month'];
                                                    $output[$c]['year'] = $result['year'];
                                                    $output[$c]['transunion'] = $result['transunion'];
                                                    $output[$c]['experian'] = $result['experian'];
                                                    $output[$c]['equifax'] = $result['equifax'];
                                                    $c++;
                                                }
                                                ?>
                                                <table class="table table-bordered rptable">
                                                    <tbody>
                                                    <tr class="text-center">
                                                        <td class='text-right'><strong>Month:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class=''><strong>".$html['month']."</strong></td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class='text-right'><strong>Year:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            echo "<td class=''><strong>".$html['year']."</strong></td>";
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class='text-right'><strong>TransUnion:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            if($html['transunion'] == 'OK'){
                                                                echo "<td class='bg-success text-white'>".$html['transunion']."</td>";
                                                            }elseif($html['transunion'] == 'CO'){
                                                                echo "<td class='bg-dark text-white'>".$html['transunion']."</td>";
                                                            }elseif($html['transunion'] == 'LP'){
                                                                echo "<td class='bg-danger text-white'>".$html['transunion']."</td>";
                                                            }
                                                            else{
                                                                echo "<td class='bg-light'>".$html['transunion']."</td>";
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class='text-right'><strong>Experian:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            if($html['experian'] == 'OK'){
                                                                echo "<td class='bg-success text-white'>".$html['experian']."</td>";
                                                            }elseif($html['experian'] == 'CO'){
                                                                echo "<td class='bg-dark text-white'>".$html['experian']."</td>";
                                                            }elseif($html['experian'] == 'LP'){
                                                                echo "<td class='bg-danger text-white'>".$html['experian']."</td>";
                                                            }
                                                            else{
                                                                echo "<td class='bg-light'>".$html['experian']."</td>";
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class='text-right'><strong>Equifax:</strong></td>
                                                        <?php
                                                        foreach ($output as $key => $html)
                                                        {
                                                            if($html['equifax'] == 'OK'){
                                                                echo "<td class='bg-success text-white'>".$html['equifax']."</td>";
                                                            }elseif($html['equifax'] == 'CO'){
                                                                echo "<td class='bg-dark text-white'>".$html['equifax']."</td>";
                                                            }elseif($html['equifax'] == 'LP'){
                                                                echo "<td class='bg-danger text-white'>".$html['equifax']."</td>";
                                                            }else{
                                                                echo "<td class='bg-light'>".$html['equifax']."</td>";
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach()


                                    <div class="col-md-12">
                                        <h3 class="text-center mt-3 mb-3">Inquiries</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped rptable" >
                                                <thead>
                                                <th class="col-3 bg-blue text-white">Creditor Name</th>
                                                <th class="col-3 bg-blue text-white">Type of Business</th>
                                                <th class="col-3 bg-blue text-white">Date of inquiry</th>
                                                <th class="col-3 bg-blue text-white">Credit Bureau</th>
                                                </thead>
                                                <tbody>
                                                @foreach($report->bureauInquiries as $inquiry)
                                                    <tr>
                                                        <td>{{ $inquiry->creditor_name }}</td>
                                                        <td>{{ $inquiry->type_of_business }}</td>
                                                        <td>{{ $inquiry->date_of_inquiry }}</td>
                                                        <td>{{ $inquiry->credit_bureau }}</td>
                                                    </tr>
                                                @endforeach()
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h3 class="text-center mt-3 mb-3">Creditor Contacts</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped rptable" >
                                                <thead>
                                                <th class="col-4 bg-blue text-white">Creditor Name</th>
                                                <th class="col-4 bg-blue text-white">Address</th>
                                                <th class="col-4 bg-blue text-white">Phone Number</th>
                                                </thead>
                                                <tbody>
                                                @foreach($report->bureauContacts as $contact)
                                                    <tr>
                                                        <td>{{ $contact->creditor_name }}</td>
                                                        <td>{{ $contact->address }}</td>
                                                        <td>{{ $contact->phone_number }}</td>
                                                    </tr>
                                                @endforeach()
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!--/ tabs -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal body -->
                <form class="new-event--form" action="{{ route('business.client.upload.file',$client->id)  }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label">Document Title (Must Be Unique):</label>
                            <input type="text" class="form-control form-control-alternative"
                                   placeholder="Document Title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="document">Document (Max 10MB):</label>
                            <input type="file" required name="document" id="document" class="form-control form-control-alternative">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-calendar="update">Upload</button>
                        <button class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
            {{--<h5 class="modal-title" id="exampleModalCenterTitle">Add New Document</h5>--}}
            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
            {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
            {{--</div>--}}
            {{--<form action="{{ route('business.client.upload.file',$client->id) }}" method="POST">--}}
            {{--<div class="modal-body">--}}
            {{--@csrf--}}

            {{--<input required id="document" name='upload_cont_img' type="file" >--}}
            {{--<p class="text-muted mt-2">Max File Size: 10MB</p>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            {{--<button type="submit" class="btn btn-primary">Upload</button>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showPassword() {
            var x = document.getElementById("iq_password");
            console.log(x);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
