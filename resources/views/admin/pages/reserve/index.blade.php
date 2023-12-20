@extends('admin.layout.app', [ 'pageTitle' => __('Reserved Management')])
@include('admin.layout.plugins.persianDataPicker')
@include('admin.layout.plugins.fullCalendar')


@section('content')

    @if (session('status'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card card-purple color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        Reserve Place
                    </h3>
                </div>
                <div class="card-body">
                    <div id='calendar' style="direction: rtl" dir="rtl"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">
                        Latest Reserve
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>UN-ID</th>
                            <th>Loc</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Ex</th>
                            <th>State</th>
                            <th>AC</th>
                        </tr>
                        @foreach($reserves as $reserve)
                            <tr>
                                <td>{{$reserve->user->user_name}}-{{$reserve->user->id}} </td>
                                <td>{{$reserve->timePlace->location->name}} </td>
                                <td>{{verta($reserve->timePlace->date)}} </td>
                                <td>{{$reserve->timePlace->time}}</td>
                                <td>{!!  ($reserve->game_id || !empty($reserve->food)) ? '<i class="fas fa-check text-success"></i>' : ''!!}</td>
                                <td>{{ $reserve->translateState() }}</td>
                                <td><a href="{{route('reserve.show',$reserve)}}"><button class="btn btn-info"><i class="fas fa-search "></i></button></a> </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                    <!-- /.card-body -->

            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fa',
            isRTL: true,
            firstDay:6,
            plugins: [ 'dayGrid','timeGrid' ],
            header: {
                left: 'dayGridMonth,dayGridWeek today',
                center: 'title',
                right: 'prev,next'
            },
            events:'{{route('reserve.calendarJson')}}'
        });

        calendar.render();
    });

</script>
@endpush