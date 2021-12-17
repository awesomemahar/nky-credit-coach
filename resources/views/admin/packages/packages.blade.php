@extends('layouts.admin.master')

@section('content')
    <!-- Header -->
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
                <h6 class="h2 text-white d-inline-block mb-5">Subscription Packages</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card flex-fill">
                    <!-- Card header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Packages</h3>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            @foreach($packages as $package)
                            <div class="col-3 card-deck">
                                <div class="card">
                                    <div class="card-header border-0 text-center">
                                        <h5>{{ $package->title }}</h5>
                                    </div>
                                    <img class="card-img-top" src="{{ asset($package->picture) }}" alt="Card image cap" height="200">
                                    <div class="card-body {{$theme}} text-white rounded d-flex flex-column">
                                        <h4 class="card-title text-white text-center font-weight-bold">{{ '$'.$package->monthly_price }}/mo
                                        </h4>
                                        <ul>
                                            @foreach(json_decode($package->features) as $feature)
                                            <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>

                                        <a href="{{ route('admin.edit.package',$package->id) }}"
                                           class="btn btn-block btn-sm bg-white mt-auto text-dark">Edit Package</a>
                                    </div>


                                </div>

                            </div>
                            @endforeach
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection()
