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
    @php
        $picture = asset('assets/img/image_placeholder.png');
        if(!is_null(auth()->user()->picture) && file_exists(auth()->user()->picture)){
            $picture = auth()->user()->picture;
        }
    @endphp
    <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask {{$theme}} opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <h1 class="display-2 text-white">Hello   {{ ucwords(auth()->user()->last_name)  }}</h1>
                    <p class="text-white mt-0 mb-5">This is your profile page. You can see and manage your profile through this page.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-4 order-xl-2">
                <div class="card card-profile">
                    <img src="{{ asset('/assets/business/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder" class="card-img-top">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset($picture) }}" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            {{--<a href="#" class="btn btn-sm btn-info  mr-4 ">Connect</a>--}}
                            {{--<a href="#" class="btn btn-sm btn-default float-right">Message</a>--}}
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center">
                                    <div>
                                        <span class="heading">{{ \App\Models\User::where('business_id', auth()->user()->id)->count()  }}</span>
                                        <span class="description">Clients</span>
                                    </div>
                                    <div>
                                        <span class="heading">{{ \App\Models\Video::count()  }}</span>
                                        <span class="description">Videos</span>
                                    </div>
                                    <div>
                                        <span class="heading">{{ auth()->user()->reminder->where('owner_id', auth()->user()->id)->count() }}</span>
                                        <span class="description">Reminders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="h3">
                                {{ ucwords(auth()->user()->first_name) .' ' .ucwords(auth()->user()->last_name)  }}
                            </h5>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ ucwords(auth()->user()->state) }}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ ucwords(auth()->user()->company_name) }}
                            </div>
                            @if(isset(auth()->user()->currentPlan))
                                <h5 class="mt-4">
                                    <h4>Subscried Package: <span>{{ auth()->user()->currentPlan->title }}</span></h4>
                                    <img src="{{ asset(auth()->user()->currentPlan->picture) }}" width="200" height="200" alt="package">
                                </h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
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
                        Edit Profile
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">First Name</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('first_name') is-invalid @enderror" type="text"
                                                   id="first_name" name="first_name"
                                                   value="{{ (old('first_name')) ? old('first_name') : $client->first_name }}">
                                            @error('first_name')
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
                                               class="col-md-4 col-form-label form-control-label">Last Name</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('last_name') is-invalid @enderror" type="text"
                                                   id="last_name" name="last_name"
                                                   value="{{ (old('last_name')) ? old('last_name') : $client->last_name }}">
                                            @error('last_name')
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
                                               class="col-md-4 col-form-label form-control-label">Email</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('email') is-invalid @enderror" type="email"
                                                   id="email" name="email"
                                                   value="{{ (old('email')) ? old('email') : $client->email }}">
                                            @error('email')
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
                                               class="col-md-4 col-form-label form-control-label">DOB</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('dob') is-invalid @enderror" type="date"
                                                   id="dob" name="dob"
                                                   value="{{ (old('dob')) ? old('dob') : $client->dob }}">
                                            @error('dob')
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
                                               class="col-md-4 col-form-label form-control-label">Company Name</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('company_name') is-invalid @enderror" type="text"
                                                   id="company_name" name="company_name"
                                                   value="{{ (old('company_name')) ? old('company_name') : $client->company_name }}">
                                            @error('company_name')
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
                                               class="col-md-4 col-form-label form-control-label">Zip Code</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('zip_code') is-invalid @enderror" type="number"
                                                   id="zip_code" name="zip_code"
                                                   value="{{ (old('zip_code')) ? old('zip_code') : $client->zip_code }}">
                                            @error('zip_code')
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
                                               class="col-md-4 col-form-label form-control-label">Phone</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('phone') is-invalid @enderror" type="number"
                                                   id="phone" name="phone"
                                                   value="{{ (old('phone')) ? old('phone') : $client->phone }}">
                                            @error('phone')
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
                                               class="col-md-4 col-form-label form-control-label">Phone(M)</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('phone_m') is-invalid @enderror" type="number"
                                                   id="phone_m" name="phone_m"
                                                   value="{{ (old('phone_m')) ? old('phone_m') : $client->phone_m }}">
                                            @error('phone_m')
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
                                               class="col-md-2 col-form-label form-control-label">Mailing Address</label>
                                        <div class="col-md-10">
                                    <textarea name="mailing_address" id="mailing_address" cols="30" rows="2"
                                              class="form-control @error('mailing_address') is-invalid @enderror">{{ (old('mailing_address')) ? old('mailing_address') : $client->mailing_address }}</textarea>
                                            @error('mailing_address')
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
                                               class="col-md-4 col-form-label form-control-label">City</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('city') is-invalid @enderror" type="text"
                                                   id="city" name="city"
                                                   value="{{ (old('city')) ? old('city') : $client->city }}">
                                            @error('city')
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
                                               class="col-md-4 col-form-label form-control-label">State</label>
                                        <div class="col-md-8">
                                            <input class="form-control  @error('state') is-invalid @enderror" type="text"
                                                   id="state" name="state"
                                                   value="{{ (old('state')) ? old('state') : $client->state }}">
                                            @error('state')
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
                                               class="col-md-4 col-form-label form-control-label">Picture</label>
                                        <div class="col-md-8">
                                            <div class="custom-file">
                                                <input type="file" name="picture" class="custom-file-input @error('picture') is-invalid @enderror" id="customFileLang" lang="en" onchange="loadFile(event)">
                                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                                @error('picture')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-md-4 col-form-label form-control-label">Preview </label>
                                        <div class="col-md-8">
                                            <img class="rounded-circle" id="output" width="100%" height="225px" src="{{ asset($picture) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn {{$c_color}} text-white">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection

@section('script')
    <script>
        function showPassword() {
            var x = document.getElementById("iq_password");
            console.log(x);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
