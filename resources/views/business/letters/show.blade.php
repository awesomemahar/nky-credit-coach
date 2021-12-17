@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Letters Library</h6>
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
                        <h3 class="mb-0">Show Letter</h3>

                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Title</label>
                                        <div class="col-md-8">
                                            <label for="example-text-input"
                                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($letter->title) ? $letter->title : 'N/A' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Letter Type</label>
                                        <div class="col-md-8">
                                            <label for="example-text-input"
                                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($letter->letter_type) ? $letter->letter_type : 'N/A' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Status</label>
                                        <div class="col-md-8">
                                            <label for="example-text-input"
                                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($letter->status && $letter->status == 1) ? 'Active' : (($letter->status && $letter->status == 0) ? 'Inactive' : 'N/A' ) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-12 col-form-label form-control-label">Letter</label>
                                        <div class="col-md-12 border border-dark rounded">
                                            {!! ($letter->letter) ? $letter->letter : 'N/A' !!}
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
