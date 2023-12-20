@extends('users.layout.app', [ 'pageTitle' => __('رزرو')])
@include('admin.layout.plugins.persianDataPicker')

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

        <form action="{{route('user.reserve.reserve')}}" class="form-horizontal" method="post">
            @csrf
            @method('post')

            {{ Form::hidden('reserve', false) }}

            <div class="card-body ">
                <div class="text-muted"> لطفا جهت رزرو میز در کافه فرم زیر را تگمیل کنید.</div>
                <div class="col-12 mt-3">
                        <div class="form-group row">
                            <label for="location" class="col-sm-2 col-form-label">طبقه</label>
                            <div class="col-sm-8">
                                {!! Form::select('location', $locations,old('location',null),['class'=>'form-control ','placeholder' => 'انتخاب کنید...','required']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">تعداد نفرات</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="number" min="1" value="{{old('number',1)}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleInputEmail1" class="col-sm-2 col-form-label">تاریخ</label>
                            <div class="input-group col-sm-8">
                                <input type="text" id="inputDate1" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : ''}} " placeholder="انتخاب کنید" aria-label="date1" value="{{ ($pdate) ?? '' }}" aria-describedby="date1" required readonly >

                                <div class="input-group-prepend">
                                    <span class="input-group-text cursor-pointer " id="date1" data-mdpersiandatetimepicker="" data-original-title="" title=""><i class="fas fa-lg fa-calendar"></i></span>
                                </div>
                                <input type="hidden" id="inputDate1-1" required name="date" value="{{old('date')}}" class="form-control" >
                                @if ($errors->has('date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">ساعت</label>
                            <div class="col-sm-8">
                               <div class="row">
                                   <div class="col-6">
                                       <select name="minute" class="form-control">
                                           <option value="30" {{(old('minute') === '30' ? 'selected' : '')}}>30</option>
                                           <option value="00" {{(old('minute') === '00' ? 'selected' : '')}}>00</option>

                                       </select>
                                   </div>
                                   <div class="col-6">
                                       {!! Form::selectRange('hour', 0,23,old('hour',12),['class'=>'form-control ','required']) !!}
                                   </div>

                               </div>
                            </div>
                        </div>

                        <div class="card card-purple">
                            <div class="card-header">
                                منو غذاهای ویژه
                            </div>
                            <div class="card-body">
                                <p class="text-muted"> اگر مایل باشید میتوانید از منو زیر  غذای خود را رزرو کنید:</p>
                                <p class="text-danger"> <small>توجه داشته باشید که این موارد بعدا قابل ویرایش نیست</small></p>
                                <div class="row">
                                    @foreach($foods as $food)
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card ">
                                            <img class="card-img-top" src="{{$food->pictureUrl}}" alt="Card image cap" style="height: 100px;object-fit: cover">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-center mb-1" style="float: none">{{$food->name}}</h5>
                                                <small class="text-muted ">قیمت: {{number_format($food->price)  }}</small>
                                            </div>
                                            <div class="card-footer">
                                                <input class="input_spinner" type="number" name="foods[{{$food->id}}]" value="0" min="0" step="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-lg btn-block btn-primary"> <i class="fas fa-calendar"></i> استعلام و ثبت رزرو</button>
            </div>

        </form>
        <!-- /.card-body -->
    </div>
@endsection