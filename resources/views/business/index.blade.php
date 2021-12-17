@extends('layouts.business.master')

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
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">My Clients</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ \App\Models\User::where('business_id', auth()->user()->id)->count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $c_color }} text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">My Letters</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ auth()->user()->letters->count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $c_color }} text-white rounded-circle shadow">
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">My Company</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ ucwords(auth()->user()->company_name) }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $c_color }} text-white rounded-circle shadow">
                                            <i class="ni ni-world-2"></i>
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Calender</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ auth()->user()->reminder->where('owner_id', auth()->user()->id)->count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $c_color }} text-white rounded-circle shadow">
                                            <i class="ni ni-calendar-grid-58"></i>
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
                    <div class="col-xl-3 col-md-6">

                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Training Videos</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ \App\Models\Video::count() }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $c_color }} text-white rounded-circle shadow">
                                            <i class="fas fa-video"></i>
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

            <div class="col-xl-6">
                <div class="card bg-transparent">
                    <div class="card-header {{ $c_color }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-white">Disputes</p>
                        </div>
                    </div>
                    <div class="card-body" style="min-height: 490px">
                        <div class="scroll-bar">
                            @if(count(auth()->user()->disputeLetters) > 0)
                            @foreach(auth()->user()->disputeLetters()->orderBy('created_at','desc')->limit(5)->get() as $letter)
                                <div class="border-bottom ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>{{ $letter->created_at }}</p>
                                        <a href="{{ route('get.dispute.letter', ['type'=>'creditor','id'=>$letter->id]) }}" target="_blank"><i class="fas fa-file-pdf fa-2x"></i></a>
                                    </div>
                                    <p>{{ ucfirst($letter->company) }}
                                    </p>
                                </div>
                            @endforeach
                            @else
                                <div class="border-bottom ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p></p>
                                        <p></p>
                                    </div>
                                    <p class="text-center">No data available</p>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card bg-transparent">
                    <div class="card-header {{ $c_color }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-white">Reminders</p>
                        </div>
                    </div>
                    <div class="card-body" style="min-height: 490px">
                        <div class="scroll-bar">
                            @if(count(auth()->user()->reminder) > 0)
                                @foreach(auth()->user()->reminder()->orderBy('created_at','desc')->limit(5)->get() as $reminder)
                                    <div class="border-bottom ">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>{{ $reminder->start }}</p>
                                            <p>{{ $reminder->time }}</p>
                                        </div>
                                        <p>{{ ucfirst($reminder->title) }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="border-bottom ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p></p>
                                        <p></p>
                                    </div>
                                    <p class="text-center">No data available</p>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
