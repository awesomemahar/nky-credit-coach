@extends('layouts.client.master')

@section('content')
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
                <h6 class="h2 text-white d-inline-block mb-5">Disputes Status</h6>


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
                        <!-- Card header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Disputes</h3>
                    <div class="box">
                        <a href="{{ route('business.reason.index') }}" class="{{$c_color}} text-white btn btn-sm"><i
                                    class="fas fa-plus"></i> Add Dispute Reason</a>
                    </div>
                </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>Furnisher</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>Account</th>
                                <th>TransUnion</th>
                                <th>Experian</th>
                                <th>Equifax</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($disputes as $dispute)
                                <tr>
                                    <td>{{ $dispute->accountHistory->accountTitle->title }}</td>
                                    <td>{{ $dispute->user->first_name.' '.$dispute->user->last_name }}</td>
                                    <td>{{ ucwords(str_replace("_"," ",$dispute->type))}}</td>
                                    <td>{{ $dispute->accountHistory->accountTitle->accounts[0]->account }}
                                    <td>
                                        @if($dispute->is_tu == 1)
                                            <span class="text-underline text-danger">Pending</span>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dispute->is_exp == 1)
                                            <span class="text-underline text-danger">Pending</span>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dispute->is_eqfx == 1)
                                            <span class="text-underline text-danger">Pending</span>
                                        @else
                                            <span>-</span>
                                        @endif
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
