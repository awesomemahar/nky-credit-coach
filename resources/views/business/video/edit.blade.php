@extends('layouts.business.master')

@section('content')

    <div class="header bg-blue pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Training Videos</h6>
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
                Update Video
            </div>
            <div class="card-body">
                <form action="{{ url('business/video/'.$video->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Title</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                           required id="title" name="title"
                                           value="{{ (old('title')) ? old('title') : $video->title }}">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Category</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('category') is-invalid @enderror" type="text"
                                           id="category" name="category" required
                                           value="{{ (old('category')) ? old('category') : $video->category }}">
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Video</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('video') is-invalid @enderror" type="file"
                                           id="video" name="video" required>
                                    @error('video')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control @error('status') is-invalid @enderror" name="status"
                                            id="status" required>
                                        <option value="" disabled>Select Status</option>
                                        <option
                                            value="1" {{ (old('status') == 1) ? 'selected' : (($video->status == 1) ? 'selected' : '' ) }}>
                                            Active
                                        </option>
                                        <option
                                            value="0" {{ (old('status') == 0 && old('status') != null) ? 'selected' : (($video->status == 0 && old('status') != 1) ? 'selected' : '' )  }}>
                                            InActive
                                        </option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-yellow">Update Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
