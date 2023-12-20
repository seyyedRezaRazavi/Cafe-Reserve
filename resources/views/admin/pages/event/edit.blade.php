@extends('admin.layout.app', [ 'pageTitle' => __('Edit Event')])
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

    <div class="card card-teal">
        <div class="card-header">
            <h3 class="card-title">
                New Event
            </h3>
        </div>
        <form method="post" action="{{ route('event.update',$event) }}" autocomplete="off" class="form-horizontal form-material" role="form">
            @csrf
            @method('put')

            <div class="card-body">

                <div class="form-group">
                    @php
                        $game_id_invalid = ($errors->has('event_label_id')) ? 'is-invalid' : '';
                    @endphp
                    <label for="exampleInputEmail1">Event Label</label>
                    <div class="input-group">
                        {!! Form::select('event_label_id', $event_labels,old('event_label_id',$event->event_label_id),['class'=>'form-control '.$game_id_invalid,'placeholder' => 'Pick a One...','required']) !!}
                        <div class="input-group-append">
                            <a href="#"><button type="button" class="btn btn-default"><i class="fas fa-search"></i></button></a>
                        </div>
                        @if ($errors->has('event_label_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('game_id') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : ''}} " id="" name="name" placeholder="{{ __('Name') }}" value="{{ old('name',$event->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Subtitle') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('subtitle')) ? 'is-invalid' : ''}} " id="" name="subtitle" placeholder="{{ __('Subtitle') }}" value="{{ old('subtitle',$event->subtitle) }}">
                    @if ($errors->has('subtitle'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subtitle') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Capacity') }}</label>
                    <input type="number" class="form-control {{ ($errors->has('zarfiat')) ? 'is-invalid' : ''}} " id="" name="zarfiat" placeholder="{{ __('Capacity') }}" value="{{ old('zarfiat',$event->zarfiat)}}" required>
                    @if ($errors->has('zarfiat'))
                        <div class="invalid-feedback">
                            {{ $errors->first('zarfiat') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Capacity Unit') }}</label>
                    <select class="form-control {{ $errors->has('zarfiat_unit') ? ' is-invalid' : '' }}" name="zarfiat_unit">
                        <option value="نفر" {{ (old('zarfiat_unit',$event->zarfiat_unit) == 'نفر') ? 'selected' : ''  }} >نفر</option>
                        <option value="تیم" {{ (old('zarfiat_unit',$event->zarfiat_unit) == 'تیم') ? 'selected' : ''  }}>تیم</option>
                    </select>
                    @if ($errors->has('zarfiat_unit'))
                        <div class="invalid-feedback">
                            {{ $errors->first('zarfiat_unit') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <div class="input-group">
                        <input type="text" id="inputDate1" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : ''}} " placeholder="Date" aria-label="date1" aria-describedby="date1" value="{{verta($event->date)}}" required readonly >

                        <div class="input-group-prepend">
                            <span class="input-group-text cursor-pointer " id="date2" data-mdpersiandatetimepicker="" data-original-title="" title=""><i class="fas fa-lg fa-calendar"></i></span>
                        </div>
                        <input type="hidden" id="inputDate1-1" name="date" class="form-control" value="{{$event->date}}">
                        @if ($errors->has('date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <label for="name">{{ __('Description') }}</label>
                    <textarea class="form-control {{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" >{{old('desc',$event->desc)}}</textarea>
                    @if ($errors->has('zarfiat'))
                        <div class="invalid-feedback">
                            {{ $errors->first('zarfiat') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Entrance Fee ($)') }}</label>
                    <input type="number" class="form-control {{ ($errors->has('vorodi_cost')) ? 'is-invalid' : ''}} " id="" name="vorodi_cost" placeholder="{{ __('Entrance Fee') }}" value="{{ old('vorodi_cost',$event->vorodi_cost)  }}">
                    @if ($errors->has('vorodi_cost'))
                        <div class="invalid-feedback">
                            {{ $errors->first('vorodi_cost') }}
                        </div>
                    @endif
                </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

@endsection