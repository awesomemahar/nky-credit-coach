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
                <h6 class="h2 text-white d-inline-block mb-5">Letter Flow</h6>
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
                        <h3 class="mb-0">Create Letter Flow</h3>
                        <a href="{{ route('client.letter.flows') }}" class="{{$c_color}} text-white btn btn-sm"><i
                                class="fas fa-list"></i> Letter Flows</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.letter.flow.create.post') }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                               class="form-control-label">Letter Flow Name</label>
                                        <input class="form-control  @error('flow_name') is-invalid @enderror"
                                               type="text" id="flow_name" name="flow_name"
                                               value="{{ old('flow_name') }}">
                                        @error('flow_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                               class="form-control-label">Dispute Reason</label>
                                        <select name="dispute_reason" id="" class="form-control creditor @error('dispute_reason') is-invalid @enderror">
                                            <option value="">Select Reason</option>
                                            @foreach($reasons as $id => $reason)
                                                <option value="{{ $id }}">{{ ucwords($reason) }}</option>
                                            @endforeach
                                        </select>
                                        @error('dispute_reason')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                               class="form-control-label">Bureau Flow</label>
                                        <select name="bureau_flow" id="" class="form-control @error('bureau_flow') is-invalid @enderror">
                                            <option value="">Select Bureau Flow</option>
                                            @foreach($bureau_letters as $id => $bureau_letter)
                                                <option value="{{ $id }}">{{ ucwords($bureau_letter) }}</option>
                                            @endforeach
                                        </select>
                                        @error('bureau_flow')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                               class="form-control-label">Furnisher Flow</label>
                                        <select name="furnisher_flow" id="" class="form-control @error('furnisher_flow') is-invalid @enderror">
                                            <option value="">Select Furnisher Flow</option>
                                            @foreach($furnisher_letters as $id => $furnisher_letter)
                                                <option value="{{ $id }}">{{ ucwords($furnisher_letter) }}</option>
                                            @endforeach
                                        </select>
                                        @error('furnisher_flow')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                               class="form-control-label">Collection Agency Flow</label>
                                        <select name="collection_agency_flow" id="" class="form-control @error('collection_agency_flow') is-invalid @enderror">
                                            <option value="">Select Collection Agency Flow</option>
                                            @foreach($agency_letters as $id => $agency_letter)
                                                <option value="{{ $id }}">{{ ucwords($agency_letter) }}</option>
                                            @endforeach
                                        </select>
                                        @error('collection_agency_flow')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-right" type="submit">Create Flow</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
    <script>

    </script>
@endsection
