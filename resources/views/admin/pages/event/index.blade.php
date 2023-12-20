@extends('admin.layout.app', [ 'pageTitle' => __('Event Management')])
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
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="card card-purple color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        Events
                    </h3>
                </div>
                <div class="card-body">
                    <div id='calendar' style="direction: rtl" dir="rtl"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">
                        New Event
                    </h3>
                </div>
                <form method="post" action="{{ route('event.store') }}" autocomplete="off" class="form-horizontal form-material" role="form">
                    @csrf
                    @method('post')

                    <div class="card-body">

                        <div class="form-group">
                            @php
                                $game_id_invalid = ($errors->has('event_label_id')) ? 'is-invalid' : '';
                            @endphp
                            <label for="exampleInputEmail1">Event Label</label>
                            <div class="input-group">
                                {!! Form::select('event_label_id', $event_labels,old('event_label_id',null),['class'=>'form-control '.$game_id_invalid,'placeholder' => 'Pick a One...','required']) !!}
                                <div class="input-group-append">
                                    <a href="{{route('event_label.index')}}"><button type="button" class="btn btn-default"><i class="fas fa-search"></i></button></a>
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
                            <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : ''}} " id="" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Subtitle') }}</label>
                            <input type="text" class="form-control {{ ($errors->has('subtitle')) ? 'is-invalid' : ''}} " id="" name="subtitle" placeholder="{{ __('Subtitle') }}" value="{{ old('subtitle') }}">
                            @if ($errors->has('subtitle'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('subtitle') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Capacity') }}</label>
                            <input type="number" class="form-control {{ ($errors->has('zarfiat')) ? 'is-invalid' : ''}} " id="" name="zarfiat" placeholder="{{ __('Capacity') }}" value="{{ old('zarfiat')}}" required>
                            @if ($errors->has('zarfiat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('zarfiat') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Capacity Unit') }}</label>
                            <select class="form-control {{ $errors->has('zarfiat_unit') ? ' is-invalid' : '' }}" name="zarfiat_unit">
                                <option value="نفر" {{ (old('zarfiat_unit') == 'نفر') ? 'selected' : ''  }} >نفر</option>
                                <option value="تیم" {{ (old('zarfiat_unit') == 'تیم') ? 'selected' : ''  }}>تیم</option>
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
                                <input type="text" id="inputDate1" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : ''}} " placeholder="Date" aria-label="date1" aria-describedby="date1" required readonly >

                                <div class="input-group-prepend">
                                    <span class="input-group-text cursor-pointer " id="date2" data-mdpersiandatetimepicker="" data-original-title="" title=""><i class="fas fa-lg fa-calendar"></i></span>
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
                            <label for="name">{{ __('Description') }}</label>
                            <textarea class="form-control {{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" >{{old('desc')}}</textarea>
                            @if ($errors->has('zarfiat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('zarfiat') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Entrance Fee ($)') }}</label>
                            <input type="number" class="form-control {{ ($errors->has('vorodi_cost')) ? 'is-invalid' : ''}} " id="" name="vorodi_cost" placeholder="{{ __('Entrance Fee') }}" value="{{ old('vorodi_cost') ?? 0 }}">
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
            events:'{{route('events.calendarJson')}}'
        });

        calendar.render();
    });

</script>
@endpush