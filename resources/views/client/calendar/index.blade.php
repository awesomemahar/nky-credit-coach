@extends('layouts.client.master')

@section('content')

    <div class="header header-dark {{$theme}} pb-6 content__title content__title--calendar">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h6 class="fullcalendar-title h2 text-white d-inline-block mb-0"><?php echo($page)?></h6>
                        <!-- <nav aria-label="breadcrumb" class="d-none d-lg-inline-block ml-lg-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                            </ol>
                        </nav> -->
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
                        <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                            <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month">Month</a>
                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek">Week</a>
                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay">Day</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <!-- Fullcalendar -->
                <div class="card card-calendar">
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
                <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">My Calendar</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body p-0">
                        <div class="calendar" data-toggle="reminderClendar" id="reminderClendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-event" tabindex="-1" role="dialog" aria-labelledby="new-event-label"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
            <div class="modal-content">
                <!-- Modal body -->
                <form class="new-event--form" action="{{ url('client/reminder') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label">Reminder title</label>
                            <input type="text" class="form-control form-control-alternative new-event--title"
                                   placeholder="Reminder" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Time</label>
                            <input class="form-control" type="time" value="10:30:00" id="time" name="time" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Description</label>
                            <input class="form-control" type="text" id="description" name="description">
                        </div>
                        <input type="hidden" class="new-event--start" name="start"/>
                        <input type="hidden" class="new-event--end" name="end"/>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-primary new-event--add">Add Reminder</button>
                        <button type="button" class="btn btn-link ml-auto"
                                data-dismiss="modal">Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-event" tabindex="-1" role="dialog"
         aria-labelledby="edit-event-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
            <div class="modal-content">
                <!-- Modal body -->
                <form class="new-event--form" action="{{ url('client/reminder/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" class=" edit-event--id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label">Reminder title</label>
                            <input type="text" class="form-control form-control-alternative edit-event--title"
                                   placeholder="Event Title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Time</label>
                            <input type="time" id="time" name="time" required
                                   class="form-control form-control-alternative edit-event--time">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Description</label>
                            <textarea name="description"
                                      class="form-control form-control-alternative edit-event--description textarea-autosize"
                                      placeholder="Event Desctiption"></textarea>
                            <i class="form-group--bar"></i>
                        </div>
                        <input type="hidden" class="edit-event--id">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-calendar="update">Update</button>
                        <a href="" type="button" class="btn btn-danger text-white edit-event--delete"
                           data-calendar="delete">Delete</a>
                        <button class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var Fullcalendar = (function () {

                // Variables

                var $calendar = $('[data-toggle="reminderClendar"]');

                //
                // Methods
                //

                // Init
                function init($this) {

                    // Calendar events

                    var events = [

                                @foreach($reminders as $reminder)
                            {
                                id: {{ $reminder->id }},
                                title: '{{ $reminder->title }}',
                                start: '{{ $reminder->start }}',
                                end: '{{ $reminder->end }}',
                                time: '{{ $reminder->time }}',
                                user_id: '{{ $reminder->user_id }}',
                                allDay: true,
                                className: 'bg-primary',
                                description: '{{ $reminder->description }}'
                            },
                            @endforeach

                        ],


                        // Full calendar options
                        // For more options read the official docs: https://fullcalendar.io/docs

                        options = {
                            header: {
                                right: '',
                                center: '',
                                left: ''
                            },
                            buttonIcons: {
                                prev: 'calendar--prev',
                                next: 'calendar--next'
                            },
                            theme: false,
                            selectable: true,
                            selectHelper: true,
                            editable: true,
                            events: events,

                            dayClick: function (date) {
                                var isoDate = moment(date).toISOString();
                                $('#new-event').modal('show');
                                $('.new-event--title').val('');
                                $('.new-event--start').val(isoDate);
                                $('.new-event--end').val(isoDate);
                            },

                            viewRender: function (view) {
                                var calendarDate = $this.fullCalendar('getDate');
                                var calendarMonth = calendarDate.month();

                                //Set data attribute for header. This is used to switch header images using css
                                // $this.find('.fc-toolbar').attr('data-calendar-month', calendarMonth);

                                //Set title in page header
                                $('.fullcalendar-title').html(view.title);
                            },

                            // Edit calendar event action

                            eventClick: function (event, element) {
                                console.log(event);
                                $('#edit-event input[value=' + event.className + ']').prop('checked', true);
                                $('#edit-event').modal('show');
                                $('.edit-event--id').val(event.id);
                                $('.edit-event--title').val(event.title);
                                $('.edit-event--time').val(event.time);
                                $('.edit-event--user_id').val(event.user_id);
                                $('.edit-event--delete').attr("href", 'reminder/delete/' + event.id);
                                $('.edit-event--description').val(event.description);
                            }
                        };

                    // Initalize the calendar plugin
                    $this.fullCalendar(options);


                    //
                    // Calendar actions
                    //


                    //Calendar views switch
                    $('body').on('click', '[data-calendar-view]', function (e) {
                        e.preventDefault();

                        $('[data-calendar-view]').removeClass('active');
                        $(this).addClass('active');

                        var calendarView = $(this).attr('data-calendar-view');
                        $this.fullCalendar('changeView', calendarView);
                    });


                    //Calendar Next
                    $('body').on('click', '.fullcalendar-btn-next', function (e) {
                        e.preventDefault();
                        $this.fullCalendar('next');
                    });


                    //Calendar Prev
                    $('body').on('click', '.fullcalendar-btn-prev', function (e) {
                        e.preventDefault();
                        $this.fullCalendar('prev');
                    });
                }


                //
                // Events
                //

                // Init
                if ($calendar.length) {
                    init($calendar);
                }

            })();
            $('body').on('click', '[data-calendar=delete]', function (e) {
                e.preventDefault();
                var link = $(this).attr('href');
                $('#edit-event').modal('hide');

                // Show confirm dialog
                setTimeout(function () {
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonClass: 'btn btn-secondary'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = link;
                        }
                    })
                }, 200);
            });
        });
    </script>
@endsection
