@extends('layouts.business.master')

@section('content')
    <!-- Header -->
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Training Videos</h6>


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
                        <h3 class="mb-0">Training Videos</h3>
                        <!-- <a href="add-client.php" class="btn-yellow btn btn-sm"><i class="fas fa-plus"></i> Add New
                            Client</a> -->

                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>ABC</td>
                                <td>Video Name</td>
                                <td>Lorem</td>
                                <td>Active</td>
                                <td class="table-actions">
                                    <a href="#!" class="btn btn-sm btn-success" rel="tooltip"
                                       data-placement="top" title="View " data-toggle="modal"
                                       data-target="#modal-default">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-info" data-toggle="tooltip"
                                       data-original-title="Edit">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-danger table-action-delete"
                                       data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>ABC</td>
                                <td>Video Name</td>
                                <td>Lorem</td>
                                <td>InActive</td>
                                <td class="table-actions">
                                    <a href="#!" class="btn btn-sm btn-success" rel="tooltip"
                                       data-placement="top" title="View " data-toggle="modal"
                                       data-target="#modal-default">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-info" data-toggle="tooltip"
                                       data-original-title="Edit">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-danger table-action-delete"
                                       data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
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