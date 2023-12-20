@extends('admin.layout.app', [ 'pageTitle' => __('Game Played Edit')])
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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Update Games Played
            </h3>
        </div>
        <form method="post" action="{{ route('game_played.update',$game_played) }}" autocomplete="off" class="form-horizontal form-material" role="form">
            @csrf
            @method('put')

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>UserName</label>
                            <input type="text" name="user_name" class="form-control {{ ($errors->has('user_name')) ? 'is-invalid' : ''}} " placeholder="Enter ..." value="{{old('user_name',$game_played->user->user_name)}}">
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
                            <input type="text" name="user_id" class="form-control {{ ($errors->has('user_id')) ? 'is-invalid' : ''}}" placeholder="Enter ..." value="{{old('user_id',$game_played->user_id)}}"  >
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
                    {!! Form::select('game_id', $games,old('game_id',$game_played->game_id),['class'=>'form-control '.$game_id_invalid,'placeholder' => 'Pick a One...','required']) !!}
                    @if ($errors->has('game_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('game_id') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <div class="input-group">
                        <input type="text" id="inputDate1" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : ''}} " placeholder="Persian Calendar Text" aria-label="date1" aria-describedby="date1" value="{{verta($game_played->date)}}" required readonly >

                        <div class="input-group-prepend">
                            <span class="input-group-text cursor-pointer " id="date1" data-mdpersiandatetimepicker="" data-original-title="" title=""><i class="fas fa-lg fa-calendar"></i></span>
                        </div>
                        <input type="hidden" id="inputDate1-1" name="date" class="form-control" value="{{$game_played->date}}">
                        @if ($errors->has('date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">State</label>
                    {!! Form::select('state', $states,old('state',$game_played->state),['class'=>'form-control','required']) !!}
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

@endsection