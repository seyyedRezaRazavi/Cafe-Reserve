@extends('users.layout.app', [ 'pageTitle' => __('تنظیمات')])

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
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cog"></i>  تنظیمات پروفایل
            </h3>
        </div>
        <form method="post" action="{{ route('user.profile.update') }}" autocomplete="off" class="form-horizontal form-material" role="form" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body box-profile">
                <div class="form-group">
                    <label for="name">{{ __('نام کاربری') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('user_name')) ? 'is-invalid' : ''}} " id="" name="user_name" placeholder="{{ __('نام کاربری') }}" value="{{ old('user_name',$user->user_name) }}">
                    @if ($errors->has('user_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user_name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">{{ __('نام , نام خانوادگی') }}</label>
                    <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : ''}} " id="" name="name" placeholder="{{ __('نام کاربری') }}" value="{{ old('name',$user->name) }}">
                    @if ($errors->has('user_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user_name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">{{ __('تصویر پروفایل') }}</label>

                    @if($user->pic)
                        <div class="form-group">
                            <a href="{{route('user.profile.remove_profile_picture')}}"><button type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i>حذف تصویر فعلی</button></a>
                        </div>
                    @else
                        <input type="file" class="form-control-file" name="pic" id="exampleFormControlFile1">
                        @if ($errors->has('pic'))
                            <div class="text-danger">
                                {{ $errors->first('pic') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">ثبت</button>
            </div>
        </form>
    </div>
@endsection