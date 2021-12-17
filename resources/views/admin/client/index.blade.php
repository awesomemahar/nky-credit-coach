@extends('layouts.admin.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Standard Clients</h6>


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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Clients</h3>
                        {{--                        <a href="{{ url('admin/client/create') }}" class="btn-yellow btn btn-sm"><i--}}
                        {{--                                class="fas fa-plus"></i> Add New--}}
                        {{--                            Client</a>--}}

                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Added On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ ($client->first_name) ? $client->first_name : 'N/A' }} {{ ($client->last_name) ? $client->last_name : 'N/A' }}</td>
                                    <td>{{ ($client->phone) ? $client->phone : 'N/A' }}</td>
                                    <td>{{ ($client->dob) ? $client->dob : 'N/A' }}</td>
                                    <td>Active</td>


                                    <td class="table-actions">
                                        {{--                                        <a href="{{ url('admin/credit/'.$client->id) }}" class="btn btn-sm btn-success"--}}
                                        {{--                                           data-toggle="tooltip" data-original-title="View">--}}
                                        {{--                                            <i class="fas fa-eye"></i>--}}
                                        {{--                                        </a>--}}
                                        <a href="{{ route('admin.clients.show',$client->id) }}" class="btn btn-sm btn-success"
                                           data-toggle="tooltip" data-original-title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{--                                        <a href="{{ url('admin/client/'.$client->id.'/edit') }}"--}}
                                        {{--                                           class="btn btn-sm btn-info" data-toggle="tooltip" data-original-title="Edit">--}}
                                        {{--                                            <i class="fas fa-user-edit"></i>--}}
                                        {{--                                        </a>--}}
{{--                                        <a href="{{ route('admin.client.delete', $client->id) }}"--}}
{{--                                           class="btn btn-sm btn-danger table-action-delete remove"--}}
{{--                                           data-toggle="tooltip" data-original-title="Delete">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
                                        </a>
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

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Harry Styles</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                                class="card-header bg-blue text-center align-items-center justify-content-center h-100">
                                            <p class="rotated-text text-white font-weight-bold">Client</p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="card-title">
                                                Sara Sasha
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <h5 class="p-0">(310) 111-1111 <br> <span
                                                                class="text-info font-10">sasha@gmail.com</span>
                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="p-0"><i class="fas fa-bolt text-blue"></i>
                                                        Run Credit
                                                        Wizard <br> <span class="font-8 text-center">Order
                                                                        reports
                                                                        connect
                                                                        errors</span></h5>
                                                    <h5 class="p-0"><i class="ni ni-send text-blue"></i>
                                                        Send Secure
                                                        Message <br> <span class="font-8 text-center">Via
                                                                        Client Portal</span></h5>

                                                </div>

                                            </div>
                                            <p>Status : <span class="text-success">Active</span></p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                                class="card-header bg-blue text-center align-items-center justify-content-center h-100">
                                            <p class="rotated-text text-white font-weight-bold">Scores</p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <table class="table table-responsive">
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
                                                <div class="col-md-4">
                                                    <canvas id="chart-bars"
                                                            class="chart-canvas w-100"></canvas>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                                class="card-header bg-blue text-center align-items-center justify-content-center h-100">
                                            <p class="rotated-text text-white font-weight-bold">Documents
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="card-title">
                                                Issued/Recieved
                                            </div>
                                            <div class="table-responsive">
                                                <table
                                                        class="table align-items-center table-flush table-hover">

                                                    <tbody>
                                                    <tr>
                                                        <th>
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input"
                                                                       id="table-check-all"
                                                                       type="checkbox">
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
                                                                       id="table-check-all"
                                                                       type="checkbox">
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
                                                                       id="table-check-all"
                                                                       type="checkbox">
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

                                                    <tr>
                                                        <th>
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input"
                                                                       id="table-check-all"
                                                                       type="checkbox">
                                                                <label class="custom-control-label"
                                                                       for="table-check-all"></label>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            Photo ID Copy
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

                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                                class="card-header bg-blue text-center align-items-center justify-content-center h-100">
                                            <p class="rotated-text text-white font-weight-bold">Remainders
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="card-title">
                                                Remainders
                                            </div>
                                            <div class="table-responsive">
                                                <table
                                                        class="table align-items-center table-flush table-hover">

                                                    <tbody>
                                                    <tr>
                                                        <td>12:00 AM 01/04/2013</td>
                                                        <td class="text-info">Order new reports and
                                                            score
                                                        </td>
                                                        <td><a href="#!"
                                                               class="btn btn-sm btn-danger table-action-delete"
                                                               data-toggle="tooltip"
                                                               data-original-title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>12:00 AM 01/04/2013</td>
                                                        <td class="text-info">Follow up on AMEX Dispute
                                                        </td>
                                                        <td><a href="#!"
                                                               class="btn btn-sm btn-danger table-action-delete"
                                                               data-toggle="tooltip"
                                                               data-original-title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>12:00 AM 01/04/2013</td>
                                                        <td class="text-info">Appointment with Jhon
                                                            Smith
                                                        </td>
                                                        <td><a href="#!"
                                                               class="btn btn-sm btn-danger table-action-delete"
                                                               data-toggle="tooltip"
                                                               data-original-title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>12:00 AM 01/04/2013</td>
                                                        <td class="text-info">Appointment with Jhon
                                                            Smith
                                                        </td>
                                                        <td><a href="#!"
                                                               class="btn btn-sm btn-danger table-action-delete"
                                                               data-toggle="tooltip"
                                                               data-original-title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a></td>
                                                    </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-info font-8"><i
                                                            class="fas fa-plus-circle text-info"></i> New
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

                        <div class="col-md-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                                class="card-header bg-blue text-center align-items-center justify-content-center h-100">
                                            <p class="rotated-text text-white font-weight-bold">Dispute
                                                Status
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="card-title">
                                                Remainders
                                            </div>
                                            <div class="table-responsive">
                                                <table
                                                        class="table align-items-center table-flush table-hover">
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
                                            <div class="text-center mt-3">
                                                <button class="btn-default mb-2 btn">Additional letters sent
                                                    0
                                                </button>
                                                <button class="btn mb-2 btn-success">See Detailed
                                                    View
                                                </button>
                                                <button class="btn mb-2 btn-info">Import Credit Report
                                                    PDF
                                                </button>


                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(document).ready(function ($) {
            $(".remove").click(function (e) {
                e.preventDefault();
                var href = $(this).attr("href");
                $.confirm({
                    title: 'Confirm!',
                    content: 'You are about to Delete Record. Are you sure you want to Delete this Record?',
                    buttons: {
                        YES: function () {
                            $(location).attr('href', href);
                        },
                        NO: function () {
                        }
                    }
                });
            });
        });
    </script>
@endsection
