{{-- BEGIN::Feather JS --}}
<script src="{{ asset('js/feather.min.js') }}"></script>
{{-- END::Feather JS --}}

{{-- BEGIN::Chart JS --}}
{{-- <script src="{{ asset('js/chart.min.js') }}"></script> --}}
{{-- END::Chart JS --}}

{{-- BEGIN::Dashboard JS --}}
<script src="{{ asset('js/bootstrap/dashboard.js') }}"></script>
{{-- END::Dashboard JS --}}

<!-- BEGIN:Filter Anything Script -->
<script>
    $(document).ready(function(){
        $("#myInputAnything").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#mySearchArea .card").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!-- END:Filter Anything Script -->

{{-- BEGIN::Data Tables --}}
{{-- <script src="{{ asset('dt/assets/jquery/jquery-3.3.1.js') }}"></script> --}}
<script src="{{ asset('dt/assets/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('dt/assets/datatables/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dt/assets/responsive/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('dt/assets/responsive/js/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('dt/assets/buttons/js/dataTables.buttons.js') }}"></script>
<script src="{{ asset('dt/assets/buttons/js/buttons.bootstrap5.js') }}"></script>
<script src="{{ asset('dt/assets/buttons/js/buttons.html5.js') }}"></script>
<script src="{{ asset('dt/assets/buttons/js/buttons.print.js') }}"></script>
<script src="{{ asset('dt/assets/buttons/js/buttons.colVis.js') }}"></script>
<script src="{{ asset('dt/assets/jszip/jszip.js') }}"></script>
<script src="{{ asset('dt/assets/pdfmake/pdfmake.js') }}"></script>
<script src="{{ asset('dt/assets/pdfmake/vfs_fonts.js') }}"></script>
{{-- END::Data Tables --}}

{{-- BEGIN::JS Date Time Picker --}}
<script src="{{ asset('dtp/jquery.datetimepicker.full.js') }}"></script>
<script>
    $('#initiateDate').datetimepicker({
        timepicker: false,
        datepicker: true,
        format: 'Y-m-d',
        weeks: true
    })
</script>
<script>
    $('#trialDate').datetimepicker({
        timepicker: false,
        datepicker: true,
        format: 'Y-m-d',
        weeks: true
    })
</script>
<script>
    $('#implementationDate').datetimepicker({
        timepicker: false,
        datepicker: true,
        format: 'Y-m-d',
        weeks: true
    })
</script>
{{-- END::JS Date Time Picker --}}

{{-- BEGIN::Data Tables Action --}}
<script>
    $(document).ready(function() {
        $('#ipidatatable').DataTable( {
            // dom: 'Bfrtip',
            // dom: 'Blfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 Baris', '25 Baris', '50 Baris', 'Tampilkan Semua' ]
            ],
            // buttons: [
            //     'excel',
            //     'pdf',
            //     {extend: 'print', messageTop: 'Laporan ini dicetak menggunakan IDEA'},
            //     'pageLength'
            // ],
            order: [[ 1, "asc" ]],
            language: {
                "sProcessing":   "Sedang Proses",
                "sLengthMenu":   "Tampilan _MENU_ Entri",
                "sZeroRecords":  "Tidak Ditemukan Data Yang Sesuai",
                "sInfo":         "Tampilan _START_ Sampai _END_ Dari _TOTAL_ Entri",
                "sInfoEmpty":    "Tampilan 0 Hingga 0 Dari 0 Entri",
                "sInfoFiltered": "(Disaring Dari _MAX_ Entri Keseluruhan)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Awal",
                    "sPrevious": "Balik",
                    "sNext":     "Lanjut",
                    "sLast":     "Akhir"
                }
            }
        } );
    } );
</script>
{{-- END::Data Tables Action --}}
