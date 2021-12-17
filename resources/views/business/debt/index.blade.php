@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">Debt Reduction Calculator</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card">
            <div class="card-header">Debt Reduction Calculator</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Balance
                                Date:</label>
                            <div class="col-md-8">
                                <input class="form-control" type="date" value="2018-11-23" id="example-date-input">
                            </div>
                        </div>
                    </div>
                </div>
                <h4>Creditor Information Table</h4>
                <table class="table">
                    <thead class="bg-blue text-white">
                    <tr>
                        <th>No</th>
                        <th>Creditor</th>
                        <th>Balance</th>
                        <th>Interest</th>
                        <th>Payment</th>
                        <th>Order</th>
                        <th>Reduce To</th>
                        <th>Interest-Only</th>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Card #1</td>
                        <td>4,400.00</td>
                        <td>13.00%</td>
                        <td>50.00</td>
                        <td>2</td>
                        <td>2,311.23</td>
                        <td>47.67</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Auto Loan #1</td>
                        <td>4,400.00</td>
                        <td>13.00%</td>
                        <td>50.00</td>
                        <td>2</td>
                        <td>2,311.23</td>
                        <td>47.67</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Student Loan #1</td>
                        <td>4,400.00</td>
                        <td>13.00%</td>
                        <td>50.00</td>
                        <td>2</td>
                        <td>2,311.23</td>
                        <td>47.67</td>
                    </tr>
                    <tr>
                        <td>Totals</td>
                        <td></td>
                        <td class="bg-light rounded">2222</td>
                        <td></td>
                        <td class="bg-light rounded">543545</td>
                    </tr>

                    </tbody>
                </table>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Monthly Payment</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Initial Snowball</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-4 col-form-label form-control-label">Strategy</label>
                            <div class="col-md-8">
                                <select name="" id="" class="form-control">
                                    <option value="">Snowball[Lowest Balance First]</option>
                                    <option value="">Lorem ipsum dolor sit amet,</option>
                                    <option value="">Lorem ipsum dolor sit amet,</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table mt-4">
                    <thead class="bg-blue text-white">
                    <tr>
                        <th>Creditor</th>
                        <th>Balance</th>
                        <th>Total Interest</th>
                        <th>Months to Pay Off</th>
                        <th>Month Paid Off</th>
                        <th>Met 1st Goal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Auto Loan #1</td>
                        <td>3,200.00</td>
                        <td>4334</td>
                        <td>23</td>
                        <td>Dec-2020</td>
                        <td>Sep-18</td>
                    </tr>
                    <tr>
                        <td>Card #1
                        </td>
                        <td>3,200.00</td>
                        <td>4334</td>
                        <td>23</td>
                        <td>Dec-2020</td>
                        <td>Sep-18</td>
                    </tr>
                    <tr>
                        <td>Student Loan #</td>
                        <td>3,200.00</td>
                        <td>4334</td>
                        <td>23</td>
                        <td>Dec-2020</td>
                        <td>Sep-18</td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center my-4 d-flex justify-content-center">
                    <p>Total Interest Paid : <span class="bg-light rounded">10003.93</span></p> <small>(Lower is
                        better.)</small>
                </div>

                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1">Snowball Growth Chart</h6>
                                        <!-- <h5 class="h3 mb-0">Total orders</h5> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
