@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5"><?php echo($page)?></h6>
            </div>
            <div class="card">
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Credit wizard Module</h3>
            </div>
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-steps btn-facebook btn-icon-only rounded-circle">
                        A
                    </button>


                    <div className="progress-wrapper">
                        <Progress max="100" value="100" color="default"/>
                    </div>
                    <button type="button" class="btn  btn-steps btn-facebook btn-icon-only rounded-circle">
                        B
                    </button>


                    <div className="progress-wrapper">
                        <Progress max="100" value="100" color="default"/>
                    </div>
                    <button type="button" class="btn btn-steps  btn-facebook btn-icon-only rounded-circle">
                        C
                    </button>


                </div>
                <div class="my-5 text-left">
                    <h5>Most credit reports have errors and it's your job to find them.</h5>
                    <p>A recent study found that 79% of credit reports contain error that lower the score. As a
                        credit
                        repair professional this is good news to you, because
                        most reports can be improved immediately by simply disputing the error.</p>
                    <p>Common error include false delinquency, public records, judgments and credit accounts that
                        did
                        not belong to the consumer. Sometimes these
                        errors are the work of sloppy data entry and sometimes it's due to identity theft. it is
                        important to examine the credit reports carefully and make
                        every effort to correct. Update or delete All unfavorable and incorrect information.</p>
                </div>


            </div>
            <div class="text-right m-3">
                <a href="{{ url('business/credit/form/'.$client->id) }}" class="btn btn-primary">Next <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

@endsection
