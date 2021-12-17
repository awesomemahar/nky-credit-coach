@extends('layouts.auth')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-3">
        <div class="container">
            <div class="header-body text-center mb-4">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Create an account</h1>
                        <?php
                            $string = '';
                            if(request()->has('package')){
                                $string = request()->query('package');
                            }
                        ?>
{{--                        <p class="text-lead text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary border-0 mb-0">
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
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            Sign Up
                        </div>
                        <form method="POST" action="{{ route('register') }}" role="form">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                    </div>
                                    <input id="name" type="text" placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                    </div>
                                    <?php
                                    $packages  = \App\Models\SubscriptionPackage::where('status',1)->get()
                                    ?>
                                    <select name="package" id="package" class="form-control @error('package') is-invalid @enderror">
                                            <option value="">Select Package</option>
                                        @foreach( $packages as  $package)
                                            <option value="{{$package->id}}"  {{ ($string == $package->stripe_id) ? 'selected' : '' }}>{{ $package->title. ' $'.$package->monthly_price.'/Monthly' }}</option>
                                        @endforeach
                                    </select>
                                    @error('package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
{{--                            <div class="text-muted font-italic"><small>password strength: <span class="text-success font-weight-700">strong</span></small></div>--}}
{{--                            <div class="row my-4">--}}
{{--                                <div class="col-12">--}}
{{--                                    <div class="custom-control custom-control-alternative custom-checkbox">--}}
{{--                                        <input class="custom-control-input" id="customCheckRegister" type="checkbox">--}}
{{--                                        <label class="custom-control-label" for="customCheckRegister">--}}
{{--                                            <span class="text-muted">I agree with the <a href="#!">Privacy Policy</a></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="text-center">
                                <button class="btn btn-primary mt-4">Create account</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('password.request') }}" class="text-light"><small>Forgot password?</small></a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('login') }}" class="text-light"><small>Sign In</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
