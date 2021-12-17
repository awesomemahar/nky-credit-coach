@extends('layouts.auth')
@section('head')
    <style>
        .alert.parsley {
            margin-top: 5px;
            margin-bottom: 0px;
            padding: 10px 15px 10px 15px;
        }
        .check .alert {
            margin-top: 20px;
        }
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }
        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
            text-align: center;
        }
        .credit-card-box .display-tr {
            display: table-row;
        }
    </style>
@endsection

@section('content')
    <div class="header {{$theme}} py-7 py-lg-8 pt-lg-3">
        <div class="container">
            <div class="header-body text-center mb-4">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Buy Package</h1>
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
            <div class="col-md-6 col-md-offset-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('subscription.store') }}"  id="payment-form" method="POST">
                            @csrf
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <div class="form-group" id="product-group">
                                <label for="plan"> Select Plan</label>
                                <select name="plan" id="product-group" class="form-control" data-parsley-class-handler="#product-group">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->stripe_id }}">{{ ucfirst($plan->title). ' - $'.$plan->monthly_price .'/Per Month'  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div id="card-element"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <p class="Trial P">Note: You will be charged after the trial period.</p>
                                <button id="card-button" class="btn btn-lg btn-block btn-success btn-order">Start Trial</button>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="payment-errors" id="card-errors" style="color: red;margin-top:10px;"></span>
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
    <!-- PARSLEY -->
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const stripe = Stripe('{{ env("STRIPE_KEY") }}', { locale: 'en' }); // Create a Stripe client.
        const elements = stripe.elements(); // Create an instance of Elements.
        const card = elements.create('card', { style: style }); // Create an instance of the card Element.

        card.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');


        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endsection
