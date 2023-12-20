@extends('users.layout.app', [ 'pageTitle' => __('رزرو')])
@include('admin.layout.plugins.persianDataPicker')

@section('content')
    @if(session('response')['data']['action'] == 'available')
        <form action="{{route('user.reserve.reserve')}}" method="post">
            @csrf
            @method('post')

            {{ Form::hidden('reserve', true) }}
            {{ Form::hidden('location', old('location')) }}
            {{ Form::hidden('number', old('number')) }}
            {{ Form::hidden('minute', old('minute')) }}
            {{ Form::hidden('hour', old('hour')) }}
            {{ Form::hidden('foods', json_encode(old('foods'))) }}
            {{ Form::hidden('date', \Hekmatinasser\Verta\Verta::parse(old('date'))->formatGregorian('Y/m/d')) }}


            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar"></i> تائیدیه رزرو میز
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h2> <i class="fas fa-glass-cheers"></i></h2>
                    <p> در این زمان میز جهت رزرو موجود است. آیا مایل به رزرو هستید؟ </p>
                    <button class="btn btn-success" type="submit"> <i class="fas fa-calendar-check"></i> تائید و رزرو</button>
                </div>
            </div>
        </form>
    @endif

    @if(session('response')['data']['action'] == 'unavailable')
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar"></i> تائیدیه رزرو میز
                </h3>
            </div>
            <div class="card-body text-center">
                <h2> <i class="far fa-frown fa-x2"></i></h2>
                <p>{{ session('response')['data']['msg']}} </p>
                <p> اما این ساعت ها موجود است: </p>

                @if(session('response')['data']['nearest']['upper'])
                    @php
                     $upper =session('response')['data']['nearest']['upper'];
                    $hour = explode(':',$upper['time'])[0];
                    $minute = explode(':',$upper['time'])[1];
                    @endphp

                    <form action="{{route('user.reserve.reserve')}}" method="post">
                        @csrf
                        @method('post')

                        {{ Form::hidden('reserve', true) }}
                        <input type="hidden" name="location" value="{{ $upper['location_id']}}">
                        <input type="hidden" name="number" value="{{old('number')}}">
                        <input type="hidden" name="foods" value="{{ json_encode(old('foods')) }}">
                        <input type="hidden" name="minute" value="{{$minute}}">
                        <input type="hidden" name="hour" value="{{$hour}}">
                        <input type="hidden" name="date" value="{{\Hekmatinasser\Verta\Verta::parse($upper['date'])->formatGregorian('Y-m-d')}}">
                    <button class="btn btn-success" type="submit"> {{ $upper['location']  }} - {{$upper['date']}} ساعت  {{$upper['time']}}  </button>
                    </form>
                @endif

                @if(session('response')['data']['nearest']['downer'])
                    @php
                        $downer =session('response')['data']['nearest']['downer'];
                        $hour = explode(':',$downer['time'])[0];
                        $minute = explode(':',$downer['time'])[1];
                    @endphp
                    <form action="{{route('user.reserve.reserve')}}" method="post">
                        @csrf
                        @method('post')

                        <input type="hidden" name="location" value="{{ $downer['location_id']}}">
                        <input type="hidden" name="number" value="{{old('number')}}">
                        <input type="hidden" name="foods" value="{{ json_encode(old('foods')) }}">
                        <input type="hidden" name="minute" value="{{$minute}}">
                        <input type="hidden" name="hour" value="{{$hour}}">
                        <input type="hidden" name="date" value="{{\Hekmatinasser\Verta\Verta::parse($downer['date'])->formatGregorian('Y-m-d')}}">
                    <button class="btn btn-success" type="submit"> {{ $downer['location']  }} - {{$downer['date']}} ساعت  {{$downer['time']}}  </button>
                    </form>
                @endif

            </div>
        </div>
    @endif

@endsection