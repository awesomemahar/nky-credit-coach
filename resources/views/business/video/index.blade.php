@extends('layouts.business.master')

@section('head')
    <style>
        iframe {
            width: 100%!important;
            min-height: 200px;
        }
    </style>
@endsection
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
        <div class="row">
            <!--ADD CLASSES HERE d-flex align-items-stretch-->
            @foreach($videos as $video)
                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                    <div class="card w-100">
                        @php
                            $picture = asset('assets/img/image_placeholder.jpg');
                            if(!is_null($video->thumbnail) && file_exists($video->thumbnail)){
                                $picture = $video->thumbnail;
                            }
                        @endphp
{{--                        <img src="{{ asset($picture) }}" class="card-img-top" alt="Card Image"  height="200"  style="object-fit: cover;">--}}
                        <?php
                        $embed = \Cohensive\Embed\Facades\Embed::make($video->path)->parseUrl();
                        // Will return Embed class if provider is found. Otherwie will return false - not found. No fancy errors for now.
                        if ($embed) {
                            // Set width of the embed.
                            $embed->setAttribute(['full' => '1000']);

                            // Print html: '<iframe width="600" height="338" src="//www.youtube.com/embed/uifYHNyH-jA" frameborder="0" allowfullscreen></iframe>'.
                            // Height will be set automatically based on provider width/height ratio.
                            // Height could be set explicitly via setAttr() method.
                            echo $embed->getHtml();
                        }
                        ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ ucfirst($video->title) }}</h5>
                            <p class="card-text mb-4">{{$video->description}}</p>
                            <a href="{{ url('business/video/'.$video->id)   }}" class="btn btn-primary mt-auto w-100 align-self-start"> Video</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
{{--        <div class="card-deck">--}}
{{--            @foreach($videos as $video)--}}
{{--                <div class="col-md-3 card">--}}
{{--                    @php--}}
{{--                        $picture = asset('assets/img/image_placeholder.jpg');--}}
{{--                        if(!is_null($video->thumbnail) && file_exists($video->thumbnail)){--}}
{{--                            $picture = $video->thumbnail;--}}
{{--                        }--}}
{{--                    @endphp--}}
{{--                    <img class="card-img-top" src="{{ asset($picture) }}" height="190" alt="Card image cap" style="object-fit: cover;">--}}
{{--                    <div class="card-body">--}}
{{--                        <h5 class="card-title" style="white-space: nowrap;">{{ $video->title }} lorem</h5>--}}
{{--                        <p class="">{{ $video->description }} </p>--}}
{{--                        <a href="{{ url('business/video/'.$video->id) }}" class="btn btn-primary form-control">View Details</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 card">--}}
{{--                    @php--}}
{{--                        $picture = asset('assets/img/image_placeholder.jpg');--}}
{{--                        if(!is_null($video->thumbnail) && file_exists($video->thumbnail)){--}}
{{--                            $picture = $video->thumbnail;--}}
{{--                        }--}}
{{--                    @endphp--}}
{{--                    <img class="card-img-top" src="{{ asset($picture) }}" height="190" alt="Card image cap" style="object-fit: cover;">--}}
{{--                    <div class="card-body">--}}
{{--                        <h5 class="card-title" style="white-space: nowrap;">{{ $video->title }} lorem</h5>--}}
{{--                        <p class="">{{ $video->description }} </p>--}}
{{--                        <a href="{{ url('business/video/'.$video->id) }}" class="btn btn-primary form-control">View Details</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="card">--}}

{{--                    @if (session('success'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('success') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if (session('error'))--}}
{{--                        <div class="alert alert-danger" role="alert">--}}
{{--                            {{ session('error') }}--}}
{{--                        </div>--}}
{{--                @endif--}}

{{--                <!-- Card header -->--}}
{{--                    --}}{{--<div class="card-header d-flex justify-content-between align-items-center">--}}
{{--                        --}}{{--<h3 class="mb-0">Training Videos</h3>--}}
{{--                        --}}{{--<a href="{{ url('business/video/create') }}" class="btn-yellow btn btn-sm"><i--}}
{{--                                --}}{{--class="fas fa-plus"></i> Add New--}}
{{--                            --}}{{--Video </a>--}}

{{--                    --}}{{--</div>--}}
{{--                        <div class="row">--}}
{{--                            @foreach($videos as $video)--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="card">--}}
{{--                                        @php--}}
{{--                                            $picture = asset('assets/img/image_placeholder.jpg');--}}
{{--                                            if(!is_null($video->thumbnail) && file_exists($video->thumbnail)){--}}
{{--                                                $picture = $video->thumbnail;--}}
{{--                                            }--}}
{{--                                        @endphp--}}
{{--                                        <img class="card-img-top" src="{{ asset($picture) }}" height="190" alt="Card image cap" style="object-fit: cover;">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <h5 class="card-title">Card title</h5>--}}
{{--                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
{{--                                            <a href="#" class="btn btn-primary">View Details</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    <div class="table-responsive py-4">--}}
{{--                        <table class="table table-flush" id="datatable-basic">--}}
{{--                            <thead class="thead-light">--}}
{{--                            <tr>--}}
{{--                                <th>ID</th>--}}
{{--                                <th>Title</th>--}}
{{--                                <th>Category</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}

{{--                            <tbody>--}}
{{--                            @foreach($videos as $video)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->index + 1 }}</td>--}}
{{--                                    <td>{{ ($video->title) ? $video->title : 'N/A' }}</td>--}}
{{--                                    <td>{{ ($video->category) ? $video->category : 'N/A' }}</td>--}}
{{--                                    <td>{{ ($video->status && $video->status == 1) ? 'Active' : (($video->status && $video->status == 0) ? 'Inactive' : 'N/A' ) }}</td>--}}
{{--                                    <td class="table-actions">--}}
{{--                                        <a href="{{ url('business/video/'.$video->id) }}" class="btn btn-sm btn-success"--}}
{{--                                           data-toggle="tooltip"--}}
{{--                                           data-original-title="View">--}}
{{--                                            <i class="fas fa-eye"></i>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ url('admin/video/'.$video->id.'/edit') }}"--}}
{{--                                           class="btn btn-sm btn-info" data-toggle="tooltip"--}}
{{--                                           data-original-title="Edit">--}}
{{--                                            <i class="fas fa-user-edit"></i>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ url('admin/video/'.$video->id.'/delete') }}"--}}
{{--                                           class="btn btn-sm btn-danger table-action-delete remove"--}}
{{--                                           data-toggle="tooltip" data-original-title="Delete">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
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
