@extends('admin.layout.app', [ 'pageTitle' => __('New Game')])

@section('content')

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Add New Game
            </h3>
        </div>
        <form method="post" action="{{ route('games.store') }}" autocomplete="off" class="form-horizontal form-material" role="form" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="card-body">
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


                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : ''}} " id="" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Cost (Toman)') }}</label>
                    <input type="number" class="form-control {{ ($errors->has('cost')) ? 'is-invalid' : ''}} " id="" name="cost" placeholder="{{ __('Cost (Toman)') }}" value="{{ (old('cost')) ?? 0 }}">
                    @if ($errors->has('cost'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cost') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Number Of Gameboard') }}</label>
                    <input type="number" class="form-control {{ ($errors->has('tedad_safhe')) ? 'is-invalid' : ''}} " id="" name="tedad_safhe" placeholder="{{ __('Number Of Gameboard') }}" value="{{ (old('tedad_safhe')) ?? 1 }}">
                    @if ($errors->has('tedad_safhe'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tedad_safhe') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Description') }}</label>
                    <textarea rows="5" name="desc" class="form-control {{ ($errors->has('desc')) ? 'is-invalid' : ''}}">{{ old('desc') }}</textarea>
                    @if ($errors->has('desc'))
                        <div class="invalid-feedback">
                            {{ $errors->first('desc') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Cover Picture') }}</label>

                    <input type="file" class="form-control-file" name="game_image" id="exampleFormControlFile1">
                    @if ($errors->has('game_image'))
                        <div class="text-danger">
                            {{ $errors->first('game_image') }}
                        </div>
                    @endif
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <!-- /.card-body -->
    </div>

@endsection