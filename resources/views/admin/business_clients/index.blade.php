@extends('layouts.admin.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Business Clients</h6>


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
                                        <a href="{{ route('admin.business-clients.show',$client->id) }}" class="btn btn-sm btn-success"
                                           data-toggle="tooltip" data-original-title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{--                                        <a href="{{ url('admin/client/'.$client->id.'/edit') }}"--}}
                                        {{--                                           class="btn btn-sm btn-info" data-toggle="tooltip" data-original-title="Edit">--}}
                                        {{--                                            <i class="fas fa-user-edit"></i>--}}
                                        {{--                                        </a>--}}
                                        <a href="{{ route('admin.client.delete', $client->id) }}"
                                           class="btn btn-sm btn-danger table-action-delete remove"
                                           data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fas fa-trash"></i>
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
