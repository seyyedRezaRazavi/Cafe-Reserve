@extends('users.layout.app', [ 'pageTitle' => __('خانه')])

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
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user"></i>  پروفایل
            </h3>
            <div class="card-tools">
                <a href="{{route('user.reserve.index')}}" class="btn btn-success btn-sm">
                    <i class="fas fa-calendar-check"></i>&nbsp  رزرو
                </a>

                <a href="{{route('user.profile.setting')}}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-cog"></i> تنظیمات
                </a>

            </div>
        </div>
        <div class="card-body box-profile">
            <div class="text-center">
                @if($user_data['profile_picture'])
                    <img class="profile-user-img img-fluid img-circle" src="{{$user_data['profile_picture']}}" style="height: 200px" alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('img')}}/user_placeholder.png" style="height: 200px" alt="User profile picture">
                @endif
            </div>

            <h3 class="profile-username text-center">{{ ($user_data['user_name']) ?? 'بدون نام کاربری'  }}</h3>

            <p class="text-muted text-center">{{$user_data['laghab']}}</p>

            <div class="row">
                <div class="col-4 text-center">
                    <a class="btn btn-default btn-block p-3" href="{{route('user.profile.reserve_history')}}"><i class="fas fa-calendar-check fa-3x"></i> <br>تاریخچه رزروها</a>
                </div>
                <div class="col-4 text-center">
                    <a class="btn btn-default btn-block p-3" href="{{route('user.profile.pictures')}}"><i class="fas fa-camera fa-3x"></i> <br>عکسها</a>
                </div>
                <div class="col-4 text-center">
                    <a class="btn btn-default btn-block " href="#"><i class="fas fa-trophy fa-3x"></i> <br>افتخارات<br><span class="badge badge-danger" style="font-size: 0.65em">Coming soon</span></a>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-alt"></i>   رویدادهای آتی
            </h3>
        </div>
        <div class="card-body ">
            <div class="row">
                @foreach($events as $event)
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    @if($event['picture'])
                                    <img src="{{$event['picture']}}" style="object-fit: cover;width:100%;height: 150px;" />
                                    @endif
                                </div>
                                <div class="col-7">
                                    <h3 class="mb-3">{{$event['title']}}</h3>
                                    <h6>     تاریخ : {{$event['date']}}</h6>
                                    <h6>ساعت: {{$event['time']}}</h6>
                                    <div class="text-left">
                                        <a href="{{route('user.event.show',$event['id'])}}" class="btn btn-dark"><i class="fas fa-search"></i> بررسی </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->
    </div>

@endsection

