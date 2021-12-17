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
                <h6 class="h2 text-white d-inline-block mb-5">Clients</h6>
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
                Edit Client
            </div>
            <div class="card-body">
                <form action="{{ url('business/client/'.$client->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $client->id }}">
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
                            <div class="custom-control custom-checkbox mb-3">
                                <input class="custom-control-input" id="no_email_check" name="no_email_check"
                                       type="checkbox" value="1" {{ (old('no_email_check') == 1) ? 'checked' : (($client->no_email_check == 1) ? 'checked' : '') }}>
                                <label class="custom-control-label" for="no_email_check">Client has no email(system will generate random email for sysmtem record)</label>
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
                        <div class="col-md-6"></div>
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-12">
                            <hr>
                            <h3 class="text-center font-weight-bold">IdentityIQ Credentials</h3>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="col-form-label form-control-label" type="checkbox" onclick="showPassword()"> <span> Show Password</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Username(Client)</label>
                                <div class="col-md-8">
                                    <input class="form-control  @error('iq_username') is-invalid @enderror" type="text"
                                           id="iq_username" name="iq_username"
                                           value="{{ (old('iq_username')) ? old('iq_username') : $client->iq_username }}"
                                    >
                                    @error('iq_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Password(Client)</label>
                                <div class="col-md-8">
                                    <input class="form-control  @error('iq_password') is-invalid @enderror" type="password"
                                           id="iq_password" name="iq_password"
                                           value="{{ (old('iq_password')) ? old('iq_password') : $client->iq_password }}"
                                    >
                                    @error('iq_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Last Four SSN(Client)</label>
                                <div class="col-md-8">
                                    <input class="form-control  @error('last_four_ssn') is-invalid @enderror" type="number" min="0"
                                           id="last_four_ssn" name="last_four_ssn"
                                           value="{{ (old('last_four_ssn')) ? old('last_four_ssn') : $client->last_four_ssn }}"
                                           onKeyDown="if(this.value.length==4 && event.keyCode!=8) return false;" >
                                    @error('last_four_ssn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn {{$c_color}} text-white">Update Client</button>
                    </div>
                </form>
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
    </script>
@endsection
