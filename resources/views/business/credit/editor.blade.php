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
            <div class="card-body">
                <form>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">EQUIFAX</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">EXPERIAN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                               aria-controls="contact" aria-selected="false">TransUnion</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="post">
                                <textarea id="mytextarea"></textarea>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form method="post">
                                <textarea id="mytextarea1"></textarea>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <form method="post">
                                <textarea id="mytextarea2"></textarea>
                            </form>
                        </div>
                    </div>
                </form>

                <div class="text-right m-3">
                    <a href="{{ url('business/letters') }}" class="btn btn-yellow">Finish </a>
                </div>

            </div>





        </div>

    </div>
@endsection
@section('script')

    <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea1'
        });
    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea2'
        });
    </script>
@endsection
