@extends('users.layout.app', [ 'pageTitle' => __('رویداد')])

@section('content')
    <!-- Portfolio Item Heading -->
    <h2 class="my-4">{{$event->eventLabel->name}}
        <small class="text-muted">{{$event->eventLabel->subtitle}}</small>
    </h2>

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-8">
            <img class="img-fluid" src="{{$event->eventLabel->coverPictureUrl}}" alt="" style="width: 100%;object-fit: cover" >
        </div>

        <div class="col-md-4">
            <h3 class="my-3">توضیحات:</h3>
            <p>
                {{$event->eventLabel->desc}}
            </p>
        </div>

    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->
    <h3 class="my-4">با ما همراه شوید:</h3>

    <div class="row">
        @foreach($event->eventLabel->events as $_event)
            @if( $_event->fullData()['state']=='Available')
                @php
                    $data = $_event->fullData();
                @endphp
                <div class="col-md-12 col-sm-12 mb-4 col-lg-6">
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar"></i> {{$data['title']}}
                            </h3>
                        </div>
                        <div class="card-body text-center ">
                            <div class="row">
                                <div class="col-3 bg-gray p-3 h5 border">
                                    <span>{{$data['alt_date']}}</span><br><span>{{$data['day']}}</span>
                                </div>
                                <div class="col-3 bg-gray p-3 h5 border">
                                    <span>{{$data['time']}}</span><br><span>ساعت</span>
                                </div>
                                <div class="col-3 bg-gray p-3 h5 border">
                                    <span>{{$data['zarfiat']}} {{$data['zarfiat_unit']}}</span><br><span>ظرفیت</span>
                                </div>
                                <div class="col-3 bg-gray p-3 h5 border">
                                    <span>{{$data['vorodi_cost']}}T</span><br><span>ورودی</span>
                                </div>
                            </div>
                            <div class="text-right">                            توضیحات:
                                {{$data['desc']}}
                            </div>
                        </div>
                        <div class="card-footer ">
                            @if($data['remaining'] <=0)
                                <button class="btn btn-danger btn-block" > ظرفیت تکمیل است. </button>
                            @else
                                <a class="btn btn-info btn-block" href="{{route('user.event.confirm',$_event->id)}}"> ثبت نام(باقی مانده: {{$data['remaining']}}) </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach



    </div>
    <!-- /.row -->
@endsection

