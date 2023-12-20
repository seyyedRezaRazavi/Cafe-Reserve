@extends('users.layout.app', [ 'pageTitle' => __('ثبت نام در رویداد')])

@section('content')
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-check"></i> رویداد : {{$event->name}}
            </h3>
        </div>
        <form action="{{route('user.event.registration',$event)}}" class="form-horizontal" method="post">
            @csrf
            @method('post')
            <div class="card-body ">

                <div class="form-group row">
                    <label for="location" class="col-sm-2 col-form-label">تعداد افراد</label>
                    <div class="col-sm-5">
                        <input class="input_spinner" type="number" name="tedad" value="0" min="1" max="{{$event->fullData()['remaining']}}" step="1"/>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-lg btn-block btn-primary"> <i class="fas fa-calendar"></i> ثبت نام</button>
            </div>
        </form>
    </div>
@endsection