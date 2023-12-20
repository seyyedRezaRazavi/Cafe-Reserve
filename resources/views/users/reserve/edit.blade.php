@extends('users.layout.app', [ 'pageTitle' => __('رزرو')])

@section('content')
    @if (session('error'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-check"></i> رزرو میز
            </h3>
        </div>

        <form action="{{route('user.reserve.update',$reserve)}}" class="form-horizontal" method="post">
            @csrf
            @method('put')


            <div class="card-body ">
                <div class="col-12 mt-3">

                    <div class="form-group row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">تعداد نفرات</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="number" min="1" value="{{old('number',$reserve->number)}}" required>
                        </div>
                    </div>

                    <div class="card card-purple mt-5">
                        <div class="card-header">
                            منو غذاهای ویژه
                        </div>
                        <div class="card-body">
                            <p class="text-muted"> اگر مایل باشید میتوانید از منو زیر  غذای خود را رزرو کنید:</p>

                            <h3 class="text-center text-purple" >
                                برای افزودن و یا تغییرات در غذاها، لطفا با کافه تماس بگیرید.
                            </h3>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-lg btn-block btn-primary"> <i class="fas fa-calendar"></i> ثبت تغییرات</button>
            </div>

        </form>
        <!-- /.card-body -->
    </div>
@endsection
