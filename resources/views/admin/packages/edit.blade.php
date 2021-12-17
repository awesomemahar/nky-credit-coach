@extends('layouts.admin.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Subscription Package</h6>
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
                Edit Package
            </div>
            <div class="card-body">
                <form action="{{ route('admin.edit.package.post',$package->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Title</label>
                                <div class="col-md-8">
                                    <input class="form-control  @error('title') is-invalid @enderror" type="text"
                                           id="title" name="title" value="{{ (old('title')) ? old('title') : $package->title }}">
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
                                       class="col-md-4 col-form-label form-control-label">Monthly Price</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('monthly_price') is-invalid @enderror" type="number"
                                           id="monthly_price" name="monthly_price" value="{{ (old('monthly_price')) ? old('monthly_price') : $package->monthly_price }}">
                                    @error('monthly_price')
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
                                       class="col-md-4 col-form-label form-control-label">Package Type</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text"
                                           id="package_type" name="package_type" value="{{ $package->package_type }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Number Of Clients</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text"
                                           id="no_of_clients" name="no_of_clients" value="{{ $package->no_of_clients }}" disabled>
                                </div>
                            </div>
                        </div>
                        @if(!is_null(\App\Models\BusinessSetting::where('type','fax_client')->where('value', '1')->first()))
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-md-2 col-form-label form-control-label">Per Fax Price</label>
                                    <div class="col-md-10">
                                        <input class="form-control @error('per_fax_price') is-invalid @enderror" type="number"
                                               id="per_fax_price" name="per_fax_price" value="{{ (old('per_fax_price')) ? old('per_fax_price') : $package->per_fax_price }}" step="0.001">
                                        @error('per_fax_price')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-2 col-form-label form-control-label">Description</label>
                                <div class="col-md-10">
                                    <textarea name="description" id="description" cols="30" rows="5"
                                              class="form-control @error('description') is-invalid @enderror">{{ (old('description')) ? old('description') : $package->description }}</textarea>
                                    @error('description')
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
                                       class="col-md-4 col-form-label form-control-label">Add Features Max(7)</label>
                                <div class="col-md-8">
                                    <?php
                                    if(count(json_decode($package->features, true)) < 1){
                                     $listing = 1;
                                    }else{
                                        $listing = count(json_decode($package->features, true));
                                    }
                                    ?>
                                    <div class="field_wrapper" data-fcount="{{ $listing }}">
                                        <?php
                                            $place = 0;
                                        ?>
                                        @if(count(json_decode($package->features, true)) > 0)
                                            @foreach(json_decode($package->features, true) as  $index => $feature)
                                                @if($place == 0)
                                                    <div>
                                                        <input type="text" class="form-control mb-1 @error('feature[]') is-invalid @enderror" name="feature[]" value="{{ (old('feature[]')) ? old('feature[]') : $feature}}"/>
                                                        <a href="javascript:void(0);" class="add_button mb-3 float-right" title="Add field"><img src="{{ asset('assets/img/add-icon.png') }}"/></a>
                                                        @error('feature[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                @else
                                                    <div><input type="text" class="form-control mb-1" name="feature[]" value="{{ (old('feature[]')) ? old('feature[]') : $feature}}"/><a href="javascript:void(0);" class="remove_button mb-3 float-right"><img src="{{ asset('assets/img/remove-icon.png') }}"/></a></div>
                                                @endif
                                                   <?php
                                                    $place++
                                                    ?>
                                            @endforeach
                                        @else
                                                <div>
                                                    <input type="text" class="form-control mb-1 @error('feature[]') is-invalid @enderror" name="feature[]" value="{{ (old('feature[]')) ? old('feature[]') : ''}}"/>
                                                    <a href="javascript:void(0);" class="add_button mb-3 float-right" title="Add field"><img src="{{ asset('assets/img/add-icon.png') }}"/></a>
                                                    @error('feature[]')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Picture</label>
                                <div class="col-md-8">
                                    <input class="form-control mb-3 @error('picture') is-invalid @enderror" type="file"
                                           id="picture" name="picture" onchange="loadFile(event)">
                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @php
                                        $picture = asset('assets/img/image-place.jpg');
                                        if(!is_null($package->picture) && file_exists($package->picture)){
                                            $picture = $package->picture;
                                        }
                                    @endphp
                                    <img class="" id="output" width="100%" height="225px" src="{{ asset($picture) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-yellow">Update Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 7; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><input type="text" class="form-control mb-1" name="feature[]" value=""/><a href="javascript:void(0);" class="remove_button mb-3 float-right"><img src="{{ asset('assets/img/remove-icon.png') }}"/></a></div>'; //New input field html
            var x = wrapper.data('fcount'); //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

        });

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
