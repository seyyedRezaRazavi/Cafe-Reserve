@extends('users.layout.app', [ 'pageTitle' => __('گالری عکسها')])

@section('content')
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user"></i> تصاویر
            </h3>
        </div>
        <div class="card-body box-profile">
            <p class="text-muted">جهت دانلود عکسها به صورت اورجینال و با کیفیت بالا، روی آنها کلیلک کنید.</p>
            <div class="row">
                @foreach($images['data'] as $image)
                    <div class="col-sm-12 col-md-6 col-lg-4 m-2">
                        <a href="{{$image['original']}}"><img src="{{$image['thumb']}}" style="width: 100%;object-fit: cover" ></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection