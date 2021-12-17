@extends('layouts.client.master')

@section('content')
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
                <h6 class="h2 text-white d-inline-block mb-5">Letters Flow</h6>
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
                        <h3 class="mb-0">Letters Flow</h3>
                        <a href="{{ route('client.letter.flow.create') }}" class="{{$c_color}} text-white btn btn-sm"><i
                                class="fas fa-plus"></i> Add New
                            Letter Flow</a>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Flow Name</th>
                                <th>Reason</th>
                                <th>Reason Added By</th>
                                <th>Bureau Letter</th>
                                <th>Furnisher Letter</th>
                                <th>Collection Agency Letter</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($flows as $flow)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ ucwords($flow->name) }}</td>
                                    <td>{{ ucwords($flow->reason->title) }}</td>
                                    <td>
                                        @if($flow->reason->user_id == auth()->user()->id)
                                            Self
                                        @else
                                            Admin
                                        @endif
                                    </td>
                                    <td>{{ (!is_null($flow->bureauLetter) ? $flow->bureauLetter->title : 'N/A') }}</td>
                                    <td>{{ (!is_null($flow->furnisherLetter) ? $flow->furnisherLetter->title : 'N/A') }}</td>
                                    <td>{{ (!is_null($flow->collectionAgencyLetter) ? $flow->collectionAgencyLetter->title : 'N/A') }}</td>
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
