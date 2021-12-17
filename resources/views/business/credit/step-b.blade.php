@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5"><?php echo($page)?></h6>


            </div>

            <div class="card">

            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Credit wizard Module</h3>
            </div>
            <div class="card-body">
                <form>
                    <h5>Step A (Review Credit Report)</h5>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Select
                            credit bureau(s):</label>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-around">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck1" type="checkbox">
                                    <label class="custom-control-label" for="customCheck1">EQUIFAX </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck1" type="checkbox">
                                    <label class="custom-control-label" for="customCheck1">EXPERIAN</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck1" type="checkbox">
                                    <label class="custom-control-label" for="customCheck1">TransUnion</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Creditor/
                            furnisher</label>
                        <div class="col-md-6">
                            <select name="" id="" class="form-control">
                                <option value="">Select Furnisher</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="text-info font-10">Add creditor/ furnisher</a>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Account
                            Number</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="text-info font-10">Different for each bureau
                                (Optional)</a>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input"
                               class="col-md-4 col-form-label form-control-label">Reason</label>
                        <div class="col-md-6">
                            <select name="" id="" class="form-control">
                                <option value="">Choose a reason for your dispute</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                            <small>("If you cannot find appropriate reason choose "Other information I would like to
                                changed")</small>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="text-info font-10">Manage Reasons</a>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                               class="col-md-4 col-form-label form-control-label">Explanation/ Instruction</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control">
                            <div class="d-flex justify-content-between">
                                <small>(i.e this is not my account. Please remove)</small>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck1" type="checkbox">
                                    <label class="custom-control-label" for="customCheck1">Save explanation for
                                        future
                                        use</label>
                                </div>
                            </div>

                            <p class="text-info">
                                <i class="fas fa-plus"></i>More Detail(Optional)

                            </p>

                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class=""><i class="fas fa-file-alt fa-2x"></i></a>

                        </div>

                    </div>
                    <p>You may add another dispute item( as many times as you like), or continue to the next step.
                    </p>
                </form>

                <div class="text-right m-3">
                    <a href="{{ url('business/credit/editor/'.$client->id) }}" class="btn btn-yellow">Next <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>





        </div>

    </div>
@endsection
