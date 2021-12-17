@extends('layouts.business.master')

@section('content')
    <!-- Header -->
    <div class="header bg-blue pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Add Client</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="card">

            <div class="card-header">
                Add Client
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">First Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Middle Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Last Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Suffix</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" placeholder="Jr, Sr, etc"
                                           id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Email</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-3">
                                <input class="custom-control-input" id="customCheck1" type="checkbox">
                                <label class="custom-control-label" for="customCheck1">Client has no email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Social Security
                                    Number</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">DOB</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="date" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Phone</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Phone Work</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Ext</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Phone(M)</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Fax</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-2 col-form-label form-control-label">Mailing Address</label>
                                <div class="col-md-10">
                                    <textarea name="" id="" cols="30" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">City</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">State</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Zip Code</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Country</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>UK</option>
                                        <option>USA</option>
                                        <option>India</option>
                                        <option>Pakistan</option>
                                        <option>China</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Password</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-4 col-form-label form-control-label">Confirm Password</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" id="example-text-input">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-yellow">Add New Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection