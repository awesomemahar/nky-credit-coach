@extends('layouts.admin.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Standard Client</h6>
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
                Show Client Details
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">First Name</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('first_name') is-invalid @enderror" type="text"
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
                                       class="col-md-4 col-form-label form-control-label">Middle Name</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('middle_name') is-invalid @enderror" type="text"
                                           id="middle_name" name="middle_name"
                                           value="{{ (old('middle_name')) ? old('middle_name') : $client->middle_name }}">
                                    @error('middle_name')
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
                                    <input readonly disabled class="form-control  @error('last_name') is-invalid @enderror" type="text"
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
                                       class="col-md-4 col-form-label form-control-label">Suffix</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('suffix') is-invalid @enderror" type="text"
                                           id="suffix" name="suffix"
                                           value="{{ (old('suffix')) ? old('suffix') : $client->suffix }}"
                                           placeholder="Jr, Sr, etc">
                                    @error('suffix')
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
                                    <input readonly disabled class="form-control  @error('email') is-invalid @enderror" type="email"
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
                                       type="checkbox" value="1" readonly disabled {{ (old('no_email_check') == 1) ? 'checked' : (($client->no_email_check == 1) ? 'checked' : '') }}>
                                <label class="custom-control-label" for="no_email_check">Client has no email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Social Security
                                    Number</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('social_security_number') is-invalid @enderror"
                                           type="number" id="social_security_number" name="social_security_number"
                                           value="{{ (old('social_security_number')) ? old('social_security_number') : $client->social_security_number }}">
                                    @error('social_security_number')
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
                                    <input readonly disabled class="form-control  @error('dob') is-invalid @enderror" type="date"
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
                                       class="col-md-4 col-form-label form-control-label">Phone</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('phone') is-invalid @enderror" type="number"
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
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Phone Work</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('phone_work') is-invalid @enderror" type="number"
                                           id="phone_work" name="phone_work"
                                           value="{{ (old('phone_work')) ? old('phone_work') : $client->phone_work }}">
                                    @error('phone_work')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Ext</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('ext') is-invalid @enderror" type="number"
                                           id="ext" name="ext"
                                           value="{{ (old('ext')) ? old('ext') : $client->ext }}">
                                    @error('ext')
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
                                    <input readonly disabled class="form-control  @error('phone_m') is-invalid @enderror" type="number"
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
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Fax</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('fax') is-invalid @enderror" type="number"
                                           id="fax" name="fax"
                                           value="{{ (old('fax')) ? old('fax') : $client->fax }}">
                                    @error('fax')
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
                                    <textarea name="mailing_address" readonly disabled id="mailing_address" cols="30" rows="2"
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
                                    <input readonly disabled class="form-control  @error('city') is-invalid @enderror" type="text"
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
                                    <input readonly disabled class="form-control  @error('state') is-invalid @enderror" type="text"
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
                                       class="col-md-4 col-form-label form-control-label">Zip Code</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('zip_code') is-invalid @enderror" type="number"
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
                                       class="col-md-4 col-form-label form-control-label">Country</label>
                                <div class="col-md-8">
                                    <select class="form-control @error('country') is-invalid @enderror" id="country"
                                            name="country">
                                        <option {{ (old('country') == 'UK') ? 'selected' : (($client->country == 'UK') ? 'selected' : '') }}>UK</option>
                                        <option {{ (old('country') == 'USA') ? 'selected' : (($client->country == 'USA') ? 'selected' : '') }}>USA</option>
                                        <option {{ (old('country') == 'India') ? 'selected' : (($client->country == 'India') ? 'selected' : '') }}>India</option>
                                        <option {{ (old('country') == 'Pakistan') ? 'selected' : (($client->country == 'Pakistan') ? 'selected' : '') }}>Pakistan</option>
                                        <option {{ (old('country') == 'China') ? 'selected' : (($client->country == 'China') ? 'selected' : '') }}>China</option>
                                    </select>
                                    @error('country')
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
                                       class="col-md-4 col-form-label form-control-label">Password</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control  @error('password') is-invalid @enderror" type="password"
                                           id="password" name="password">
                                    @error('password')
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
                                       class="col-md-4 col-form-label form-control-label">Confirm Password</label>
                                <div class="col-md-8">
                                    <input readonly disabled class="form-control" type="password"
                                           id="password_confirmation" name="password_confirmation" value="">
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>

@endsection
