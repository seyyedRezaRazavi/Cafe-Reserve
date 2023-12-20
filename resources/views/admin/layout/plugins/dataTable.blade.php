
@push('js')

<!-- Data Table -->
<script src="{{asset('Admin_lte')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{asset('Admin_lte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $("#data_table1").DataTable({
            "order": [],

        });
    });
    $(function () {
        $("#data_table2").DataTable({
            "order": [],

        });
    });
</script>

@endpush

@push('style')
<!-- Data Table -->
<link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endpush