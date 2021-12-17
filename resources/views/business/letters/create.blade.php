@extends('layouts.business.master')

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
                        <h3 class="mb-0">Create Letter</h3>
                        <div class="box">
                            {{--<a href="{{ route('business.keys') }}" class="btn-blue text-white btn btn-sm"><i--}}
                                        {{--class="fas fa-plus"></i> Add Keys</a>--}}
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ url('business/letters') }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Title</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('title') is-invalid @enderror"
                                                   type="text" id="title" name="title" required
                                                   value="{{ old('title') }}">
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
                                               class="col-md-4 col-form-label form-control-label">Letter Type</label>
                                        <div class="col-md-8">
                                            <select class="form-control @error('letter_type') is-invalid @enderror"
                                                    name="letter_type"
                                                    id="letter_type" required>
                                                <option value="" selected disabled>Letter Type</option>
                                                <option value="Bureau" {{ (old('letter_type') == 1) ? 'selected' : '' }}>Bureau
                                                </option>
                                                <option
                                                    value="Furnisher" {{ (old('letter_type') == 0 && old('letter_type') != null) ? 'selected' : '' }}>
                                                    Furnisher
                                                </option>
                                                <option
                                                    value="Collection Agency" {{ (old('letter_type') == 'Collection Agency' && old('letter_type') != null) ? 'selected' : '' }}>
                                                    Collection Agency
                                                </option>
                                            </select>
                                            @error('letter_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <p class="text-info text-sm">Important: Select carefully, you cant change letter type.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Status</label>
                                        <div class="col-md-8">
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    name="status"
                                                    id="status" required>
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="1" {{ (old('status') == 1) ? 'selected' : '' }}>Active
                                                </option>
                                                <option
                                                    value="0" {{ (old('status') == 0 && old('status') != null) ? 'selected' : '' }}>
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
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Bulk</label>
                                        <div class="col-md-8">
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="bulk_letters" class="onoffswitch-checkbox reason-switch" id="myonoffswitch" tabindex="0">
                                                <label class="onoffswitch-label" for="myonoffswitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="display-block mb-5">
                                <h4>Keys: </h4>
                                @foreach($keys as $key)
                                    <button class="btn btn-info add_key mb-2"
                                          data-key="{{ $key->value }}">
                                        {!! $key->key !!}
                                    </button>

                                @endforeach
                            </div>
                            <textarea id="mytextarea" name="letter"></textarea>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="text-right">
                                        <button type="submit" class="btn {{$c_color}} text-white">Add New Letter</button>
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
