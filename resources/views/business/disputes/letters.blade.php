@extends('layouts.business.master')

@section('content')
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
                <h6 class="h2 text-white d-inline-block mb-5">Disputes Letters</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                @endif
                <!-- Card header -->
                    <!-- Card header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Disputes</h3>
                        <div class="box">
                            <a href="{{ route('business.reason.index') }}" class="{{$c_color}} text-white btn btn-sm"><i
                                        class="fas fa-plus"></i> Add Dispute Reason</a>
                        </div>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>Client</th>
                                <th>Date</th>
                                <th>To</th>
                                @if(!is_null(\App\Models\BusinessSetting::where('type','fax_client')->where('value', '1')->first()))
                                    <th>Fax Sent</th>
                                @endif
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($letters as $letter)
                                <tr>
                                    <td>
                                        {{ ucwords($letter->dispute->user->first_name). ' '.ucwords($letter->dispute->user->last_name) }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $letter->created_at)->format('M/d/Y H:i') }}</td>
                                    <td>
                                        {{ $letter->company }}
                                    </td>
                                    @if(!is_null(\App\Models\BusinessSetting::where('type','fax_client')->where('value', '1')->first()))
                                        <td>
                                            @if($letter->company == 'TransUnion' || $letter->company == 'Experian'  || $letter->company == 'Equifax' )
                                                {{ ($letter->fax_sent == 1 ? 'Yes' : 'No') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        {{ ucwords(str_replace("_"," ",$letter->dispute->type))  }}
                                    </td>
                                    <td>
                                        <a href="{{ route('get.dispute.letter', ['id'=>$letter->id]) }}" target="_blank">
                                            <i class="fas fa-file-pdf fa-2x"></i>
                                        </a>
                                        <a href="{{ route('edit.dispute.letter', ['id'=>$letter->id]) }}"  class="ml-3">
                                            <i class="fas fa-edit fa-2x"></i>
                                        </a>
                                        @if(!is_null(\App\Models\BusinessSetting::where('type','fax_client')->where('value', '1')->first()))
                                            @if($letter->company == 'TransUnion' || $letter->company == 'Experian'  || $letter->company == 'Equifax' )
                                                @if($letter->fax_sent == 0)
                                                    <a href="{{ route('business.fax.dispute.letter', ['id'=>$letter->id]) }}"  class="ml-3">
                                                        <i class="fas fa-fax fa-2x"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection
