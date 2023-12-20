@push('style')
<!-- Farsi WebFont: BFont.ir -->
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fullcalendar-interaction/main.min.css">
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fullcalendar-bootstrap/main.min.css">

<style>

    @font-face {
        font-family: 'B Yekan';
        src: url('{{asset('yekan')}}/FontName.eot');
        src: url('{{asset('yekan')}}/FontName.eot?#iefix') format('FontName-opentype'),
        url('{{asset('yekan')}}/FontName.woff') format('woff'),
        url('{{asset('yekan')}}/FontName.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }


    .fc{
        font-family: "B Yekan" !important;
    }
    #calendar  .fc-center h2{
        font-family: "B Yekan" !important;
        direction: rtl;
    }
    .fc-title{
        font-size: 1.1em !important;
        color: white !important;
        font-family: "B Yekan";
        direction: rtl;
    }
    .fc-content{
        text-align: right;
        direction: ltr;
    }

    .fc-header-toolbar{
        direction: ltr;
    }
</style>
@endpush

@push('js')
<!-- fullCalendar -->
<script src="{{asset('Admin_lte')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/fullcalendar/main.min.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/fullcalendar-interaction/main.min.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/fullcalendar-bootstrap/main.min.js"></script>
@endpush