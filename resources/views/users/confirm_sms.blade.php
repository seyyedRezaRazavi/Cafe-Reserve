<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mr fun Club- Garmsar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('login_template')}}/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{asset('login_template')}}/css/main.css">
    <!--===============================================================================================-->
    <style>
        @font-face {
            font-family: 'Yekan';
            src: url('{{asset('yekan')}}/Yekan.eot');
            src: url('{{asset('yekan')}}/Yekan.eot?#iefix') format('FontName-opentype'),
            url('{{asset('yekan')}}/Yekan.woff') format('woff'),
            url('{{asset('yekan')}}/Yekan.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        input::-webkit-input-placeholder {
            color: grey;
        }
        body{
            font-family: 'Yekan';
        }
    </style>
</head>
<body dir="rtl" style="direction: rtl">


<div class="container-login100" style="background-image: url('{{asset('login_template')}}/images/bg-01.jpg');">

    <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
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

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span>کد تائیدیه به {{$number}} ارسال شد. </span>
                    </div>
                </div>
            </div>
        <form class="login100-form " action="{{route('user.login.confirm_pin')}}" method="post">
            @csrf
            @method('post')
				<span class="login100-form-title p-b-37" style=" font-family: 'B Yekan' ">ورود به سیستم</span>

            <div class="wrap-input100  m-b-20" >
                <input class="input100" type="tel" name="pin" placeholder="" dir="rtl" style=" font-family: 'B Yekan';direction: rtl " required>
                <span class="focus-input100"></span>
            </div>
            <div class="text-center p-b-50 ">
					<span class="txt1" style=" font-family: 'B Yekan';direction: rtl;font-size: 0.9em">لطفا کد تائید ارسالی را وارد کنید</span>
            </div>


            <div class="container-login100-form-btn">
                <button class="login100-form-btn" style=" font-family: 'B Yekan';direction: rtl  ">ورود</button>
            </div>

            <input type="hidden" name="number" value="{{$number}}">

        </form>


    </div>
</div>



<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="{{asset('login_template')}}/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="{{asset('login_template')}}/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="{{asset('login_template')}}/vendor/bootstrap/js/popper.js"></script>
<script src="{{asset('login_template')}}/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="{{asset('login_template')}}/js/main.js"></script>

</body>
</html>