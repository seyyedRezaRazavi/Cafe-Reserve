@push('js')
<script src="{{asset('Admin_lte')}}/plugins/persianDataPick/jquery.md.bootstrap.datetimepicker.js" type="text/javascript"></script>

<script>
    $('#date1').MdPersianDateTimePicker({
        targetTextSelector: '#inputDate1',
        targetDateSelector: '#inputDate1-1',
        dateFormat: 'yyyy-MM-dd'
    });
    $('#date2').MdPersianDateTimePicker({
        targetTextSelector: '#inputDate1',
        targetDateSelector: '#inputDate1-1',
        textFormat:'yyyy/MM/dd  HH:mm',
        dateFormat: 'yyyy-MM-dd HH:mm',
        enableTimePicker: true
    });
</script>
@endpush


@push('style')
<link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/persianDataPick/jquery.md.bootstrap.datetimepicker.style.css">
@endpush