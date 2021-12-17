@extends('layouts.admin.master')

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
                <form action="{{ url('admin/video/'.$video->id) }}" method="POST" enctype="multipart/form-data">
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
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="example-text-input"--}}
{{--                                       class="col-md-4 col-form-label form-control-label">Video</label>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <input class="form-control @error('video') is-invalid @enderror" type="file"--}}
{{--                                           id="video" name="video" required>--}}
{{--                                    @error('video')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Video</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('path') is-invalid @enderror" type="text"
                                           id="path" name="path" value="{{ (old('path')) ? old('path') : $video->path }}" required>
                                    @error('path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-md-3">--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="example-text-input"--}}
{{--                                       class="col-md-4 col-form-label form-control-label">Type</label>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <select class="form-control @error('type') is-invalid @enderror" name="type"--}}
{{--                                            id="type" required>--}}
{{--                                        <option value="" disabled>Select Type</option>--}}
{{--                                        <option--}}
{{--                                            value="1" {{ (old('type') == 1) ? 'selected' : (($video->type == 1) ? 'selected' : '' ) }}>--}}
{{--                                            Business--}}
{{--                                        </option>--}}
{{--                                        <option--}}
{{--                                            value="0" {{ (old('type') == 0 && old('type') != null) ? 'selected' : (($video->type == 0 && old('type') != 1) ? 'selected' : '' )  }}>--}}
{{--                                            Client--}}
{{--                                        </option>--}}
{{--                                    </select>--}}
{{--                                    @error('status')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
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

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-2 col-form-label form-control-label">Description</label>
                                <div class="col-md-10">
                                    <textarea name="description" id="" cols="30" rows="5" required class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}">{{ (old('description')) ? old('description') : $video->description }}
                                    </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="thumbnail"--}}
{{--                                       class="col-md-4 col-form-label form-control-label">Thumbnail</label>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <input class="form-control @error('thumbnail') is-invalid @enderror" type="file"--}}
{{--                                           id="thumbnail" name="thumbnail"   onchange="loadFile(event)">--}}
{{--                                    @error('thumbnail')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                    <label for="example-text-input"--}}
{{--                                           class="col-md-4 col-form-label form-control-label">Preview</label>--}}

{{--                                    @php--}}
{{--                                        $picture = asset('assets/img/image_placeholder.jpg');--}}
{{--                                        if(!is_null($video->thumbnail) && file_exists($video->thumbnail)){--}}
{{--                                            $picture = $video->thumbnail;--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                    <img  id="output" width="100%" height="180px" src="{{ asset($picture) }}" style="object-fit: cover;"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                    <div class="text-right">
                        <button class="btn {{$c_color}} text-white">Update Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // var loadFile = function(event) {
        //     var output = document.getElementById('output');
        //     output.src = URL.createObjectURL(event.target.files[0]);
        //     output.onload = function() {
        //         URL.revokeObjectURL(output.src) // free memory
        //     }
        // };
    </script>
@endsection
