@extends('layouts.business.master')

@section('content')
    <!-- Header -->
    <!-- Header -->
    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">FINANCIAL CALCULATOR</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card">
            <div class="card-header">Credit Card Payoff Calculator</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-items-center align-middle">
                        <div class="card">
                            <div class="card-header {{$theme}} text-white">Credit Card Info</div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Current Balance</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Interest Rate</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Interest-only Payment</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header {{$theme}} text-white">A. Calculate Months to Payoff</div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Monthly Payment

                                            <br>
                                            <small>(Needs to be greater then the interest-only payment)</small>
                                        </td>
                                        <td><input type="number" class="form-control"> </td>
                                    </tr>
                                    <tr>
                                        <td>Months to Payoff</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Interest</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header {{$theme}} text-white">B. Calculate Monthly Payment</div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Payoff Goal (Months)


                                        </td>
                                        <td><input type="number" class="form-control"> </td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Payment</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Amortization Interest</td>
                                        <td><input type="number" class="form-control"></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection