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
                <h6 class="h2 text-white d-inline-block mb-5">Letter Editor</h6>
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
                        <h3 class="mb-0">Edit Dispute Letter</h3>
                        <div class="box">
                            {{--<a href="{{ route('business.keys') }}" class="btn-blue text-white btn btn-sm"><i--}}
                            {{--class="fas fa-plus"></i> Add Keys</a>--}}
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.edit.dispute.letter.post',$letter->id) }}" method="post">
                            @csrf
                            <textarea id="mytextarea" name="letter">{!! ($letter->letter) ? $letter->letter : '' !!}</textarea>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="text-right">
                                        <button type="submit" name="submitButton" class="btn {{$c_color}} text-white" value="pdf">Get PDF(Without Save)</button>

                                        <button type="submit" name="submitButton" class="btn {{$c_color}} text-white" value="update">Update Letter</button>
                                    </div>
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

        tinymce.init({
            selector: '#mytextarea',
            height: "480",
            init_instance_callback : function(editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });

        $(".add_key").click(function (e) {
            e.preventDefault();
            tinymce.get('mytextarea').execCommand('insertHTML', false, $(this).data('key'));
        });
    </script>
@endsection
