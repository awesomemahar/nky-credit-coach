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
                <h6 class="h2 text-white d-inline-block mb-5">Subscription Forms</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Subscription Forms</h3>
                        <a href="{{ route('admin.subscription.add') }}" class="{{$c_color}} text-white btn btn-sm"><i class="fas fa-plus"></i>
                            Add
                            New
                            Subscription</a>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-header border-0 text-center">
                                        <h5>Basic Package</h5>
                                        <p>1 Month</p>
                                    </div>
                                    <img class="card-img-top" src="{{ asset('assets\admin\img\img1.jpg') }}" alt="Card image cap">
                                    <div class="card-body {{$theme}} text-white rounded">
                                        <h4 class="card-title text-white text-center font-weight-bold">$ 09.00/mo
                                        </h4>
                                        <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing
                                            elit. Voluptatum, eos.</p>

                                        <a href="javascript:void(0)"
                                           class="btn btn-block btn-sm bg-white  text-dark">Get
                                            Started</a>
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-header border-0 text-center">
                                        <h5>Annual Package</h5>
                                        <p>12 Month</p>
                                    </div>
                                    <img class="card-img-top" src=" {{ asset('assets\admin\img\img2.jpg') }}" alt="Card image cap">
                                    <div class="card-body {{$theme}} text-white rounded">
                                        <h4 class="card-title text-white text-center font-weight-bold">$ 30.00/ye
                                        </h4>
                                        <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing
                                            elit. Voluptatum, eos.</p>

                                        <a href="javascript:void(0)"
                                           class="btn btn-block btn-sm bg-white  text-dark">Get
                                            Started</a>
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-header border-0 text-center">
                                        <h5>Premium Package</h5>
                                        <p>6 Month</p>
                                    </div>
                                    <img class="card-img-top" src="{{ asset('assets\admin\img\img3.jpg') }}" alt="Card image cap">
                                    <div class="card-body {{$theme}} text-white rounded">
                                        <h4 class="card-title text-white text-center font-weight-bold">$ 6.00/mo
                                        </h4>
                                        <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing
                                            elit. Voluptatum, eos.</p>

                                        <a href="javascript:void(0)"
                                           class="btn btn-block btn-sm bg-white  text-dark">Get
                                            Started</a>
                                    </div>


                                </div>

                            </div>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection()
