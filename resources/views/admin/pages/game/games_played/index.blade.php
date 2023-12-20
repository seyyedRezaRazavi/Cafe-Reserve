@extends('admin.layout.app', [ 'pageTitle' => __('Game Played Management')])
@include('admin.layout.plugins.dataTable')
@include('admin.layout.plugins.persianDataPicker')


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
                        Games Played
                    </h3>
                </div>
                <div class="card-body">
                    <table id="data_table1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('UserName (Code)') }}</th>
                            <th>{{ __('Game') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('state') }}</th>
                            <th class="text-right">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($games_played as $game_played)
                            <tr>
                                <td>
                                    {{ ($game_played->user->user_name) ?? 'unknown'   }} - {{$game_played->user->id}}
                                </td>
                                <td>
                                    {{ $game_played->game->name }}
                                </td>
                                <td>
                                    {{ $game_played->pdate }}
                                </td>
                                <td>
                                    {{ $game_played->stateTranslate() }}

                                </td>
                                <td class="td-actions text-right">
                                    <form action="{{ route('game_played.destroy', $game_played) }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <a rel="tooltip" class="btn btn-success" href="{{ route('game_played.edit', $game_played) }}" data-original-title="" title="">
                                            <i class="fas fa-edit"></i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this  played?") }}') ? this.parentElement.submit() : ''">
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
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">
                        New Games Played
                    </h3>
                </div>
                <form method="post" action="{{ route('game_played.store') }}" autocomplete="off" class="form-horizontal form-material" role="form">
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

                                @php
                                    $game_id_invalid = ($errors->has('game_id')) ? 'is-invalid' : '';
                                @endphp

                                <label for="exampleInputEmail1">Game</label>
                                {!! Form::select('game_id', $games,old('game_id',null),['class'=>'form-control '.$game_id_invalid,'placeholder' => 'Pick a One...','required']) !!}
                                @if ($errors->has('game_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('game_id') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Date</label>
                                <div class="input-group">
                                    <input type="text" id="inputDate1" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : ''}} " placeholder="Date" aria-label="date1" aria-describedby="date1" required readonly >

                                    <div class="input-group-prepend">
                                        <span class="input-group-text cursor-pointer " id="date1" data-mdpersiandatetimepicker="" data-original-title="" title=""><i class="fas fa-lg fa-calendar"></i></span>
                                    </div>
                                    <input type="hidden" id="inputDate1-1" name="date" class="form-control" >
                                    @if ($errors->has('date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('date') }}
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">State</label>
                                {!! Form::select('state', $states,old('state',null),['class'=>'form-control','required']) !!}
                            </div>

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