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
    <div class="header {{$theme}}  pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Subscription Forms</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="card">

            <div class="card-header">
                Add Subscription
            </div>
            <div class="card-body">
                <form>


                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Package
                            Name</label>
                        <div class="col-md-8">
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Gold</option>
                                <option>Silver</option>
                                <option>Diamond</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Total
                            Amount</label>
                        <div class="col-md-8">
                            <input class="form-control" type="number" id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                               class="col-md-4 col-form-label form-control-label">Duration</label>
                        <div class="col-md-8">
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Monthly</option>
                                <option>Yearly</option>
                                <option>1 Month</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Discounts
                            (%)</label>
                        <div class="col-md-8">
                            <input class="form-control" type="number" id="example-text-input">
                        </div>
                    </div>


                    <div class="text-right">
                        <button class="btn btn-sm {{ $c_color }} text-white">ADD NEW SUBSCRIPTION</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
