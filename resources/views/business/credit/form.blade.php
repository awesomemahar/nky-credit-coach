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
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="custom-control custom-radio mb-3">
                            <input name="custom-radio-4" class="custom-control-input" id="customRadio8"
                                   type="radio">
                            <label class="custom-control-label" for="customRadio8">Round 1 Basic Dispute (Credit
                                Bureaus)</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input name="custom-radio-5" class="custom-control-input" id="customRadio9"
                                   type="radio">
                            <label class="custom-control-label" for="customRadio9">All other letters(Credit Bureaus,
                                Creditors/Furnishers or Collections)</label>
                        </div>
                    </div>
                    <p>Enter Report Number you want to create a letter for</p>
                    <h6>Report Number :</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">EQUIFAX #</label>
                                <input type="text" class="form-control">

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">EXPERIAN #</label>
                                <input type="text" class="form-control">

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">TransUnion #</label>
                                <input type="text" class="form-control">

                            </div>
                        </div>
                    </div>
                    <div class="d-flex  align-items-center">
                        <h5>Step B (Add Items you wish to dispute)</h5>
                        <button class="btn btn-primary ml-4"><i class="fas fa-plus-circle"></i> ADD NEW
                            ITEMS</button>

                    </div>
                    <div class="table-responsive">
                        <table class="table my-4">
                            <thead class="bg-light">
                            <tr>
                                <th>Creditor/Furnisher</th>
                                <th>Reason</th>
                                <th>EQUIFAX</th>
                                <th>EXPERIAN</th>
                                <th>TransUnion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Sears Card</td>
                                <td>The following account is not mine</td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                            </tr>
                            <tr>
                                <td>American Express</td>
                                <td>The following account was a Bankruptcy/Charge-off. Balance should be $0</td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                    <small>Negative</small>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex mt-3">
                        <h5>Step C</h5>
                        <p class="ml-4">In the left column above, check the dispute items that you wish to include
                            in this
                            letter. We suggest never spending more
                            then 5 dispute items within a 30 day period. Any remaining unchecked items will be saved
                            as "Pending" to include in another
                            Round 1 Dispute Letter in 0 days. When you're ready to continue, click "Next".</p>

                    </div>
                </form>

                <div class="text-right m-3">
                    <a href="{{ url('business/credit/step-b/'.$client->id) }}" class="btn btn-primary">Next <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>
        </div>
    </div>
@endsection
