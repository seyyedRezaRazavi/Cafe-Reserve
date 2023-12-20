@extends('admin.layout.app', [ 'pageTitle' => __('Edit Event Label')])

@section('content')

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Edit Event Label
            </h3>
        </div>
        <form method="post" action="{{ route('event_label.update',$event_label) }}" autocomplete="off" class="form-horizontal form-material" role="form" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                    <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : ''}} " id="" name="name" placeholder="{{ __('Name') }}" value="{{ old('name',$event_label->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Subtitle') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('subtitle')) ? 'is-invalid' : ''}} " id="" name="subtitle" placeholder="{{ __('Subtitle') }}" value="{{ old('subtitle',$event_label->subtitle) }}">
                    @if ($errors->has('subtitle'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subtitle') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Description') }}</label>
                    <textarea rows="5" name="desc" class="form-control {{ ($errors->has('desc')) ? 'is-invalid' : ''}}">{{ old('desc',$event_label->desc) }}</textarea>
                    @if ($errors->has('desc'))
                        <div class="invalid-feedback">
                            {{ $errors->first('desc') }}
                        </div>
                    @endif
                </div>

                    <div class="form-group">
                        <label for="name">{{ __('Cover Picture') }}</label>

                        @if($event_label->picture)
                            <div class="form-group">
                                <a href="{{route('event_label.remove_cover_picture',$event_label)}}"><button type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i>Remove Picture</button></a>
                            </div>

                        @else
                            <input type="file" class="form-control-file" name="label_image" id="exampleFormControlFile1">
                            @if ($errors->has('label_image'))
                                <div class="text-danger">
                                    {{ $errors->first('label_image') }}
                                </div>
                            @endif
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