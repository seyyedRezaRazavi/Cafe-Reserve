@extends('admin.layout.app', [ 'pageTitle' => __('TimePlace Profile')])
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
                This Time,This Place
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered col-lg-5 col-md-12 col-sm-12" >
                <tr>
                    <th>Location</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>{{$timePlace->location->name}}</td>
                    <td>{{verta($timePlace->date)->format('Y/n/j')}}</td>

                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Reserveded
            </h3>
        </div>
        <div class="card-body">
            <table id="data_table1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Username-ID</th>
                    <th>Time</th>
                    <th>Number</th>
                    <th>Reserved Food</th>
                    <th>Reserved Game</th>
                    <th>State</th>
                    <th>Reservation Date</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reserves as $reserve)
                    <tr>
                        <td>{{$reserve->user->user_name}} -{{$reserve->user->id}} </td>
                        <td>{{date('H:i',strtotime($reserve->timePlace->time))}}</td>
                        <td>{{$reserve->number}}</td>
                        <td>{{$reserve->food}}</td>
                        <td>{{($reserve->game_id) ? $reserve->game->name : ''}}</td>
                        <td>{{$reserve->translateState()}}</td>
                        <td>{{verta($reserve->created_at)}}</td>
                        <td class="td-actions text-right">
                            <form action="{{ route('reserve.destroy', $reserve) }}" method="post">
                                @csrf
                                @method('delete')

                                @if($reserve->state != -1)
                                <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to Cancel this Reserve?") }}') ?  location.href='{{route('reserve.cancel',$reserve)}}' : ''">
                                    <i class="fa fa-calendar-times"></i>
                                </button>
                                @endif

                                <a rel="tooltip" class="btn btn-success" href="{{ route('reserve.edit', $reserve) }}" data-original-title="" title="">
                                    <i class="fas fa-edit"></i>
                                    <div class="ripple-container"></div>
                                </a>
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

@endsection