@extends('layouts.business.master')

@section('content')

    <div class="header {{$theme}} pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <h6 class="h2 text-white d-inline-block mb-5">letter Keys</h6>


            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
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
                    @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <!-- Card header -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Keys</h3>
                            <div class="box">
                                <a href="{{ route('business.keys') }}" class="btn-blue text-white btn btn-sm"><i
                                            class="fas fa-plus"></i> Add Keys</a>
                                <a href="{{ url('business/letters/create') }}" class="btn-yellow btn btn-sm"><i
                                            class="fas fa-plus"></i> Add New
                                    Letter</a>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 p-5">
                                <div class="">
                                    <h3 class="mt-5">Add New Key: </h3>
                                    <p></p>
                                    <span class="text-danger">- Key should be unique.</span> <br>
                                    <span class="text-danger">- Only single space and characters are allowed.</span> <br>
                                    <span class="text-danger">- Key will be generated automatically in <strong>[ABX_XYZ]</strong> syntax.</span>
                                    <br>
                                    <span class="text-danger">- Spaces will turn to _ and lowercase automatically turns into <strong>Uppercase</strong> along with starting and closing <strong>[ ]</strong>.</span>

                                    <hr>
                                    <form class="new-event--form" action="{{ route('business.keys.post')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-control-label">KEY(MAX LENGTH 15)</label>
                                            <input type="text" class="form-control"
                                                   placeholder="" name="key" required maxlength="15">
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">Add Key</button>
                                    </form>
                                </div>

                            </div>
                            <div class="col-md-6 p-5">
                                <h3 class="mt-5">Keys:</h3>
                                <div class="table-responsive py-4">
                                    <table class="table table-bordered" >
                                        <thead class="thead-light">
                                        <tr>
                                            <th>KEY</th>
                                            <th>Button Preview</th>
                                            <th>Letter Preview</th>
                                            <th>Active</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($keys as $key)
                                        <tr class="text-center">
                                            <td>{{ $key->key }}</td>
                                            <td><button class="btn btn-info btn-sm w-100">{{ $key->key }}</button></td>
                                            <th>{{ $key->value }}</th>
                                            <td>Yes</td>
                                        </tr>
                                        @endforeach
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
@section('script')
    <script>
        jQuery(document).ready(function ($) {
            $(".remove").click(function (e) {
                e.preventDefault();
                var href = $(this).attr("href");
                $.confirm({
                    title: 'Confirm!',
                    content: 'You are about to Delete Record. Are you sure you want to Delete this Record?',
                    buttons: {
                        YES: function () {
                            $(location).attr('href', href);
                        },
                        NO: function () {
                        }
                    }
                });
            });
        });
    </script>
@endsection
