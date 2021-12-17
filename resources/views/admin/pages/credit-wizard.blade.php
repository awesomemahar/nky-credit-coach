@extends('layouts.admin.master')
@section('content')
    <!-- Header -->
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Credit Wizard</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Credit Wizard</h3>


            </div>

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
                                            Sara Sasha
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <h5 class="p-0">(310) 111-1111 <br> <span
                                                            class="text-info font-10">sasha@gmail.com</span>
                                                </h5>
                                                <p>Status : <span class="text-success">Active</span></p>

                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="p-0"><i class="fas fa-bolt text-blue"></i>
                                                    <a href="credit-wizard-module.php"> Run Credit
                                                        Wizard</a> <br> <span class="font-8 text-center">Order
                                                            reports
                                                            connect
                                                            errors</span>
                                                </h5>
                                                <h5 class="p-0"><i class="ni ni-send text-blue"></i>
                                                    Send Secure
                                                    Message <br> <span class="font-8 text-center">Via
                                                            Client Portal</span> </h5>

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
                                <div class="col-md-11">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-small">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-danger">EQUIFAX</th>
                                                        <th class="text-blue">EXPERIAN</th>
                                                        <th class="text-success">TransUnion</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>01/04/2013</td>
                                                        <td>333</td>
                                                        <td>333</td>
                                                        <td>333</td>
                                                    </tr>
                                                    <tr>
                                                        <td>01/04/2013</td>
                                                        <td>333</td>
                                                        <td>333</td>
                                                        <td>333</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div
                                                        class="d-flex font-8 justify-content-between align-items-center">
                                                    <p class="font-8">Start Date :
                                                        <span>11/02/2020</span>
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

                    <div class="col-6  mb-3">
                        <div class="card">
                            <div class="row h-100">
                                <div class="col-md-1   p-0 ">
                                    <div
                                            class="card-header {{$theme}} text-center align-items-center justify-content-center h-100">
                                        <p class="rotated-text text-white font-weight-bold">Documents
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="card-body">
                                        <div class="card-title">
                                            Issued/Recieved
                                        </div>
                                        <div class="table-responsive" style="max-height:100px; overflow-y:scroll;">
                                            <table
                                                    class="table  table-small align-items-center table-flush table-hover">

                                                <tbody>
                                                <tr>
                                                    <th>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input"
                                                                   id="table-check-all" type="checkbox">
                                                            <label class="custom-control-label"
                                                                   for="table-check-all"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        Client Agreement
                                                    </td>
                                                    <td><i class="fas fa-file-medical"></i>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input"
                                                                   id="table-check-all" type="checkbox">
                                                            <label class="custom-control-label"
                                                                   for="table-check-all"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        Client Credit: File Rights
                                                    </td>
                                                    <td><i class="fas fa-file-medical"></i>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input"
                                                                   id="table-check-all" type="checkbox">
                                                            <label class="custom-control-label"
                                                                   for="table-check-all"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        Client Recommendations
                                                    </td>
                                                    <td><i class="fas fa-file-medical"></i>
                                                    </td>

                                                </tr>



                                                </tbody>
                                            </table>
                                        </div>

                                        <a href="javascript:void(0) " class="font-8 text-info">Customise
                                            List</a>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card ">
                            <div class="row h-100">
                                <div class="col-md-1 p-0  ">
                                    <div
                                            class="card-header {{$theme}} text-center align-items-center justify-content-center h-100">
                                        <p class="rotated-text text-white font-weight-bold">Reminders
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="card-body">
                                        <div class="card-title">
                                            Reminders
                                        </div>
                                        <div class="table-responsive" style="max-height:100px; overflow-y:scroll;">
                                            <table
                                                    class="table align-items-center  table-small table-flush table-hover">

                                                <tbody>
                                                <tr>
                                                    <td>12:00 AM 01/04/2013</td>
                                                    <td class="text-info">Order new reports and
                                                        score</td>
                                                    <td> <a href="#!"
                                                            class="btn btn-sm btn-danger table-action-delete"
                                                            data-toggle="tooltip" data-original-title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a></td>
                                                </tr>
                                                <tr>
                                                    <td>12:00 AM 01/04/2013</td>
                                                    <td class="text-info">Follow up on AMEX Dispute
                                                    </td>
                                                    <td> <a href="#!"
                                                            class="btn btn-sm btn-danger table-action-delete"
                                                            data-toggle="tooltip" data-original-title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a></td>
                                                </tr>
                                                <tr>
                                                    <td>12:00 AM 01/04/2013</td>
                                                    <td class="text-info">Appointment with Jhon
                                                        Smith</td>
                                                    <td> <a href="#!"
                                                            class="btn btn-sm btn-danger table-action-delete"
                                                            data-toggle="tooltip" data-original-title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a></td>
                                                </tr>




                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-info font-8"><i class="fas fa-plus-circle text-info"></i>
                                                New
                                                Reminder
                                            </p>
                                            <a href="javascript:void(0) " class="font-8 text-info">Show
                                                More</a>
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
                                        <p class="rotated-text text-white font-weight-bold">Dispute
                                            Status
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="card-body">
                                        <div class="card-title">
                                            Reminders
                                        </div>
                                        <div class="table-responsive" style="max-height:200px; overflow-y:scroll;">
                                            <table
                                                    class="table align-items-center   table-small table-flush table-hover">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-danger">EQUIFAX</th>
                                                    <th class="text-blue">EXPERIAN</th>
                                                    <th class="text-success">TransUnion</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td class="text-success">Positive</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-success">Deleted</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-success">Repaired</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">InDispute</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">Verified</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">Negative</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>
                                                <tr>
                                                    <td class="">Created/Saved</td>
                                                    <th>7</th>
                                                    <th>7</th>
                                                    <th>7</th>
                                                </tr>






                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center mt-3 d-flex">
                                            <a class="btn btn-blue text-white btn-sm mb-2 btn">Additional letters
                                                sent
                                                0</a>
                                            <a class="btn mb-2 btn-sm  btn-success">See Detailed
                                                View</a>
                                            <a class="btn mb-2 btn-sm  btn-info">Import Credit Report
                                                PDF</a>





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
@endsection

