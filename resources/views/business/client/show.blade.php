@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">My Videos</h6>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
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

            <div class="card-header">
                Show Video
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Title</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label">{{ ($video->title) ? $video->title : 'N/A' }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Category</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label">{{ ($video->category) ? $video->category : 'N/A' }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">status</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label">{{ ($video->status && $video->status == 1) ? 'Active' : (($video->status && $video->status == 0) ? 'Inactive' : 'N/A' ) }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2">
                            <div class="col-12 text-center"><label class=""> Video </label></div>
                            <div class="col-8 ml-auto mr-auto">
                                <video style="width:100%" controls id="video_src">
                                    <source src="{{Storage::disk('public')->exists($video->path) ? Storage::disk('public')->url($video->path) : ''}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
