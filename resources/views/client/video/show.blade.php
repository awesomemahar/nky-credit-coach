@extends('layouts.client.master')

@section('content')

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
                Show Video
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Title</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($video->title) ? $video->title : 'N/A' }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Category</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($video->category) ? $video->category : 'N/A' }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">status</label>
                            <label for="example-text-input"
                                   class="col-md-8 col-form-label form-control-label font-weight-bolder">{{ ($video->status && $video->status == 1) ? 'Active' : (($video->status && $video->status == 0) ? 'Inactive' : 'N/A' ) }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2">
                            <div class="col-12 text-center"><label class=""> Video </label></div>
                            <div class="col-8 ml-auto mr-auto">
                                <?php
                                $embed = \Cohensive\Embed\Facades\Embed::make($video->path)->parseUrl();
                                // Will return Embed class if provider is found. Otherwie will return false - not found. No fancy errors for now.
                                if ($embed) {
                                    // Set width of the embed.
                                    $embed->setAttribute(['width' => 600]);

                                    // Print html: '<iframe width="600" height="338" src="//www.youtube.com/embed/uifYHNyH-jA" frameborder="0" allowfullscreen></iframe>'.
                                    // Height will be set automatically based on provider width/height ratio.
                                    // Height could be set explicitly via setAttr() method.
                                    echo $embed->getHtml();
                                }
                                ?>
                                {{--                                <x-embed url="{{ ($video->path) ? $video->path : '' }}"/>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
