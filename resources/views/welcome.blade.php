@extends('layouts.auth')
@section('content')
    <div class="header {{$theme}} py-7 py-lg-8 pt-lg-3">
        <div class="container">
            <div class="header-body text-center mb-4">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Welcome</h1>
                        <p class="text-lead text-white">New Credit Dispute Eraser</p>
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
            @foreach(\App\Models\SubscriptionPackage::whereNotNull('stripe_id')->get() as $package)
                <div class="col-3 card-deck">
                    <div class="card">
                        <div class="card-header border-0 text-center">
                            <h5>{{ $package->title }}</h5>
                        </div>
                        <img class="card-img-top" src="{{ asset($package->picture) }}" alt="Card image cap" height="200">
                        <div class="card-body {{$theme}} text-white rounded d-flex flex-column">
                            <h4 class="card-title text-white text-center font-weight-bold">{{ '$'.$package->monthly_price }}/mo
                            </h4>
                            <ul>
                                @foreach(json_decode($package->features) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                                    <li>7 Days free trial included</li>
                            </ul>

                            <a href="{{ route('register',['package'=>$package->stripe_id]) }}"
                               class="btn btn-block btn-sm bg-white mt-auto text-dark">Start Free Trial</a>
                        </div>


                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
