@extends('layouts.admin.master')

@section('content')
    <!-- Header -->
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Subscription & Payments</h6>


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
                        <h3 class="mb-0">Subscriptions</h3>
                        <!-- <a href="add-client.php" class="btn-yellow btn btn-sm"><i class="fas fa-plus"></i> Add New
                            Client</a> -->

                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Package Type</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>ABC</td>
                                <td>23 Dec 2012</td>
                                <td>XYZ JOHN</td>
                                <td>Starter</td>
                                <td>Stripe</td>
                                <td><span class="badge badge-danger">Declined</span></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <!-- Footer -->
        </div>
    </div>
@endsection()
