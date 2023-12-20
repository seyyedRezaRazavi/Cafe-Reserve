@extends('admin.layout.app', [ 'pageTitle' => __('Event Label Profile')])
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
                    <th>Name</th>
                    <th>Subtitle</th>
                    <th>Description</th>
                    <th>Cover Picture</th>
                    <th>Created Date</th>
                </tr>
                <tr>
                    <td>{{$event_label->name}}</td>
                    <td>{{$event_label->subtitle}}</td>
                    <td>{{$event_label->desc}}</td>
                    <td>
                        @if($event_label->cover_picture_url != null)
                            <a href="{{ $event_label->cover_picture_url }}"> {{ $event_label->picture }} </a>
                        @endif
                    </td>
                    <td>{{verta($event_label->created_at)}}</td>

                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Events
            </h3>
        </div>
        <div class="card-body">
            <table id="data_table1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ __('Id Code') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('state') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event_label->events as $event)
                    <tr>
                        <td>
                            {{ $event->id }}
                        </td>
                        <td>
                            {{ $event->name }}
                        </td>
                        <td >
                            {{ verta($event->date)  }}
                        </td>
                        <td class="">
                           <div class="badge {{($event->fullData()['state'] == 'Expire') ? 'badge-danger' : 'badge-success'}}">{{ $event->fullData()['state'] }}</div>
                        </td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-info" href="{{ route('event.show', $event) }}" data-original-title="" title="">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection