@extends('layouts.client.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}" />
    <style>
        .tabs {
            /*margin: 0px 20px;*/
            position: relative;
            background: white;
            border: 1px solid #e3e3e3;
            box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            min-height: 630px;
        }
        .heading-st{
            background: #f1f1f1;
        }

        .tabs nav {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            background: #f1f1f1;
            color: black;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.2);
            width: 250px;
            height: max-content;
        }

        .tabs nav a {
            padding: 20px 0px;
            text-align: center;
            width: 100%;
            cursor: pointer;
        }

        .tabs nav a:hover,
        .tabs nav a.selected {
            background: #ccc;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
        }

        .tabs .content {
            padding: 20px 0px;
            position: absolute;
            top: 0px;
            left: 250px;
            color: #6C5D5D;
            width: 0px;
            height: 100%;
            overflow: hidden;
            opacity: 0;
            transition: opacity 0.1s linear 0s;
        }

        .tabs .content.visible {
            padding: 20px;
            width: calc(100% - 250px);
            overflow: scroll;
            opacity: 1;
            background: #f1f1f1;
        }

        .tabs .content p { padding-bottom: 2px; }

        .tabs .content p:last-of-type { padding-bottom: 0px; }

        .tox-notification .tox-notification--in .tox-notification--warning{
            display: none!important;
        }
    </style>
@endsection
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
                <h6 class="h2 text-white d-inline-block mb-5">Dispute Letter(s)</h6>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
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
                <div class="tabs">
                    <nav>
                        @foreach($letters as $letter)
                            <a>{{ $letter->company }}</a>
                        @endforeach
                    </nav>
                    @foreach($letters as $index => $letter)
                    <div class="content">
                        <h3 class="heading-st">Review you letter and fill the bold content with your details and save the letter</h3>
                        <form action="{{ route('client.edit.dispute.editor.letter.post',$letter->id) }}" class="letterForm" method="post">
                            @csrf
                            <textarea class="mytextarea" name="letter">{!! ($letter->letter) ? $letter->letter : '' !!}</textarea>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="text-right">
                                        @if ($index === array_key_last($letters->toArray()))
                                            <button type="submit" name="submitButton" class="btn {{$c_color}} text-white" value="update">Save</button>
                                        @endif
                                        <button type="submit" name="submitButton" class="btn {{$c_color}} text-white" value="continue">Save & Continue</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
    <!-- Toastr JS for alerts  -->
    <script src="{{ asset('assets/js/toastr.js') }}"></script>
    @include('includes.elements.alerts')
    <script>

        tinymce.init({
            selector: 'textarea',
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

        $('.tabs nav a').on('click', function() {
            show_content($(this).index());
        });

        show_content(0);

        function show_content(index) {
            // Make the content visible
            $('.tabs .content.visible').removeClass('visible');
            $('.tabs .content:nth-of-type(' + (index + 1) + ')').addClass('visible');

            // Set the tab to selected
            $('.tabs nav a.selected').removeClass('selected');
            $('.tabs nav a:nth-of-type(' + (index + 1) + ')').addClass('selected');
        }

        $(function() {
            $(".letterForm").submit(function(event) {
                event.preventDefault();
                var task = '';
                if($(document.activeElement).val() == 'continue'){
                    task = 1
                }
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize() + '&task=' + task,// serializes the form's elements.
                }).done(function(response) {
                    console.log(response);
                    if(response.error == false){
                        toastr.success(response.msg);
                        if(response.redirect == true){
                            window.location.href = "{{ route('client.disputes') }}";
                        }
                    }else{
                        toastr.error(response.msg);
                    }
                });
            });
        });
    </script>
@endsection
