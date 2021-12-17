@extends('layouts.client.master')

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
                <h6 class="h2 text-white d-inline-block mb-5">Dispute Reasons</h6>


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
                        <h3 class="mb-0">Reason</h3>
                        <div class="box">
                            <a href="{{ route('business.disputes') }}" class="{{$c_color}} text-white btn btn-sm"><i
                                        class="fas fa-plus"></i> Disputes </a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 p-5">
                            <div class="">
                                <h3 class="mt-5">Add New Reason: </h3>

                                <p class="text-danger"><strong>
                                        - Reason Title should be unique.
                                    </strong>
                                </p>
                                <hr class="mt-2">
                                <form class="new-event--form" action="{{ route('client.reason.store')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-control-label">Title (MAX LENGTH 50)</label>
                                        <input type="text" class="form-control"
                                               placeholder="" name="title" required maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Content</label>
                                        <textarea  name="content" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">Add Reason</button>
                                </form>
                            </div>

                        </div>
                        <div class="col-md-6 p-5">
                            <h3 class="mt-5">Reasons:</h3>
                            <div class="table-responsive py-4">
                                <table class="table table-bordered" >
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($reasons as $reason)
                                        <tr class="text-center">
                                            <td>{{ $reason->title }}</td>
                                            <td>
                                                @if($reason->status == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>
                                                @if(auth()->user()->id == $reason->user_id)
                                                    <a  class="reason-edit" href="" data-reason="{{$reason->id}}" data-title="{{$reason->title}}"  data-content="{{$reason->content}}" data-status="{{ $reason->status }}" data-ref="{{ route('business.reason.update',$reason) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
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

    <div class="modal fade" id="ReasonModel" tabindex="-1" role="dialog"
         aria-labelledby="edit-event-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
            <div class="modal-content">
                <!-- Modal body -->
                <form id="reasonForm" action="" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label">Title</label>
                            <input type="text" class="form-control form-control-alternative reason-title"
                                   placeholder="Event Title" name="title" required disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Active</label>
                            <div class="onoffswitch">
                                <input type="checkbox" name="active_switch" class="onoffswitch-checkbox reason-switch" id="myonoffswitch" tabindex="0">
                                <label class="onoffswitch-label" for="myonoffswitch"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Content</label>
                            <textarea name="content" class="form-control reason-content" id="" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-calendar="update">Update</button>
                        <button class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(document).ready(function ($) {
            {{--$(".switch-active").change(function() {--}}
                {{--if(this.checked) {--}}
                    {{--var url  = '{{route('business.update.reason.status', ['type'=>':type','id'=>':id'])}}';--}}
                    {{--url = url.replace(':type', 'checked');--}}
                    {{--url = url.replace(':id', $(this).data('reason'));--}}
                {{--}else{--}}
                    {{--var url  = '{{route('business.update.reason.status', ['type'=>':type','id'=>':id'])}}';--}}
                    {{--url = url.replace(':type', 'un-checked');--}}
                    {{--url = url.replace(':id', $(this).data('reason'));--}}
                {{--}--}}

                {{--window.location.href = url;--}}
            {{--});--}}

            $('.reason-edit').click(function(event) {
                var title = $(this).data('title');
                var status = $(this).data('status');
                var content = $(this).data('content');
                var reason = $(this).data('id');
                var url = $(this).data('ref');

                $('#reasonForm').attr('action', url);
                event.preventDefault();
                $('.reason-title').val(title);
                $('.reason-content').val(content);
                if(status == '1'){
                    $(".reason-switch").prop("checked", true);
                }else{
                    $(".reason-switch").prop("checked", false);
                }
                $('#ReasonModel').modal('show');

            });
        });
    </script>
@endsection
