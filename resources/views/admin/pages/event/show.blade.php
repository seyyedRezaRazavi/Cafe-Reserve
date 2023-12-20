@extends('admin.layout.app', [ 'pageTitle' => __('Event Profile')])
@include('admin.layout.plugins.dataTable')

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

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Event Info
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Capacity</th>
                    <th>Remaining</th>
                    <th>Desc</th>
                    <th>Entrance Fee($)</th>
                    <th>State</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                </tr>
                <tr>
                    <td>{{$event->name}}<br><sub>{{$event->subtitle}}</sub></td>
                    <td>{{$event->fullData()['alt_date']}} <br> {{$event->fullData()['day']}}</td>
                    <td>{{$event->fullData()['time']}}</td>
                    <td>{{$event->zarfiat}} {{$event->zarfiat_unit}}</td>
                    <td>{{$event->fullData()['remaining']}}</td>
                    <td>{{$event->desc}}</td>
                    <td>{{$event->vorodi_cost}}</td>
                    <td class="">
                        <div class="badge {{($event->fullData()['state'] == 'Expire') ? 'badge-danger' : 'badge-success'}}">{{ $event->fullData()['state'] }}</div>
                    </td>
                    <td class="td-actions text-right">
                        <form action="{{ route('event.destroy', $event) }}" method="post">
                            @csrf
                            @method('delete')

                            <a rel="tooltip" class="btn btn-success" href="{{ route('event.edit', $event) }}" data-original-title="" title="">
                                <i class="fas fa-edit"></i>
                                <div class="ripple-container"></div>
                            </a>
                            @if($event->fullData()['zarfiat'] == $event->fullData()['remaining'] )
                                <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this Game?") }}') ? this.parentElement.submit() : ''">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endif
                        </form>
                    </td>

                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        Event Registrations
                    </h3>
                </div>
                <div class="card-body">
                    <table id="data_table1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('Registration Date') }}</th>
                            <th>{{ __('User Name - Code') }}</th>
                            <th>{{ __('Number') }}</th>
                            <th class="text-right">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($event->eventRegistrations as $eventRegistration)
                            <tr>
                                <td>{{verta($eventRegistration->pivot->created_at)->format('Y/m/d - H:i')}}</td>
                                <td>{{$eventRegistration->user_name}} - {{$eventRegistration->id}}</td>
                                <td>{{$eventRegistration->pivot->tedad}}</td>
                                <td class="td-actions text-right">
                                    <form action="{{ route('registration.destroy', $eventRegistration->pivot->id) }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this Game?") }}') ? this.parentElement.submit() : ''">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        New Event Registration
                    </h3>
                </div>
                <form method="post" action="{{ route('registration.store') }}" autocomplete="off" class="form-horizontal form-material" role="form">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>UserName</label>
                                    <input type="text" name="user_name" class="form-control {{ ($errors->has('user_name')) ? 'is-invalid' : ''}} " placeholder="Enter ..." value="{{old('user_name')}}">
                                    @if ($errors->has('user_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('user_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Code Id</label>
                                    <input type="text" name="user_id" class="form-control {{ ($errors->has('user_id')) ? 'is-invalid' : ''}}" placeholder="Enter ..." value="{{old('user_id')}}"  >
                                    @if ($errors->has('user_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('user_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Number of Registration') }}</label>
                            <input type="number" class="form-control {{ ($errors->has('tedad')) ? 'is-invalid' : ''}} " id="" name="tedad" placeholder="{{ __('Number of Registration') }}" value="{{ (old('tedad')) ?? 1 }}">
                            @if ($errors->has('tedad'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tedad') }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="event_id" value="{{$event->id}}">

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection