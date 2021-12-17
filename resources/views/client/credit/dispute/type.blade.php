@extends('layouts.client.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" type="text/css">
@endsection
@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Create Dispute</h6>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->

        <div class="card">
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
            <!-- Card header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ ucwords(str_replace("_"," ",$type)) }}</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
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
                        <form action="{{ route('client.create.dispute',['type'=>$type]) }}" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-flush" id="dispute-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>
                                                Furnisher
                                            </th>
                                            <th>
                                                Account No
                                            </th>
                                            <th>
                                                Type
                                            </th>
                                            <th style="width: 125%">
                                                Reason
                                            </th>
                                            <th>
                                                Bureaus
                                            </th>
                                            <th>
                                                Creditor Contact(Select Carefully)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reports as $report)
                                        <?php
                                            if($report->transunion == '' || $report->transunion == 'OK'){
                                                $tu  =  false;
                                            }else{
                                            $tu  =  \App\Helpers\Helper::isDisputeValid($report->id,'is_tu',$client->id);
                                            }

                                            if($report->experian == '' || $report->experian == 'OK'){
                                                $exp  =  false;
                                            }else{
                                                $exp  =  \App\Helpers\Helper::isDisputeValid($report->id,'is_exp',$client->id);
                                            }

                                            if($report->equifax == '' || $report->equifax == 'OK'){
                                                $eqfx  =  false;
                                            }else{
                                                $eqfx  =  \App\Helpers\Helper::isDisputeValid($report->id,'is_eqfx',$client->id);
                                            }

                                        ?>
                                    @if($tu ||  $exp || $eqfx)
                                        <tr class="rowAlt">
                                        <td class="label">
                                            {{ $report->accountTitle->title }}
                                        </td>
                                        <td class="info">
                                            {{ $report->accountTitle->accounts[0]->account }}
                                        </td>
                                        <td class="info">
                                            {{ ucwords(str_replace("_"," ",$type)) }}
                                        </td>
                                        <td class="info">
                                            <select name="reason[{{$report->id}}]" id="" class="form-control creditor">
                                                @foreach($reasons as $id => $reason)
                                                    <option value="{{ $id }}">{{ ucwords($reason) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="checkbox-inline">
                                                <label class="checkbox-inline ml-2">
                                                    @if($type == 'collections')
                                                        <input {{ $report->transunion == 'CO' && $tu ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="tu"> TU
                                                    @elseif($type == 'late_payments')
                                                        <input {{ $report->transunion == 'LP' && $tu ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="tu"> TU
                                                    @endif
                                                </label>
                                                <label class="checkbox-inline ml-2">
                                                    @if($type == 'collections')
                                                        <input {{ $report->experian == 'CO' && $exp ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="exp"> EXP
                                                    @elseif($type == 'late_payments')
                                                        <input {{ $report->experian == 'LP' && $exp ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="exp"> EXP
                                                    @endif
                                                </label>
                                                <label class="checkbox-inline ml-2">
                                                    @if($type == 'collections')
                                                        <input {{ $report->equifax == 'CO' && $eqfx ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="eqfx"> EQFX
                                                    @elseif($type == 'late_payments')
                                                        <input {{ $report->equifax == 'LP'&& $eqfx ?  : 'disabled' }} name="bureau[{{$report->id}}][]" type="checkbox" value="eqfx"> EQFX
                                                    @endif
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="creditor[{{$report->id}}]" id="" class="form-control creditor" data-placeholder="Select Creditor Contact">
                                                @foreach($creditors as $creditor)
                                                    <option value=""></option>
                                                    <option value="{{ $creditor->id }}">{{ $creditor->creditor_name.': '. $creditor->address }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-info float-right mt-2">Create Dispute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#dispute-table').dataTable({
                pageLength: 25,
                ordering: false,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },
                drawCallback: function(dt) {
                    console.log("draw() callback; initializing Select2's.");
                    $('div.dataTables_length select').removeClass('custom-select custom-select-sm');
                    $(".reason, .creditor").select2({
                        placeholder: "Select Creditor",
                    });
                }
            });

        });
    </script>
@endsection
