 <!-- Global stylesheets -->
 <link href="{{URL::asset('assets/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/css/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
 <!-- /global stylesheets -->
 @yield('css')

 <!-- Core JS files -->
 <script src="{{URL::asset('assets/demo/demo_configurator.js')}}"></script>
 <script src="{{URL::asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
 <script src="{{URL::asset('assets/js/jquery/jquery.min.js')}}"></script>
 <script src="{{URL::asset('assets/js/datatable/datatable.min.js')}}"></script>
 <script src="{{URL::asset('assets/js/select2/select2.min.js')}}"></script>
 <script src="{{URL::asset('assets/js/sweetalert/sweetalert2.js')}}"></script>

 <link href="{{URL::asset('assets/css/datatable.min.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">

<script src="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/scripts/verify.min.js"></script>

{{-- <link href="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet"> --}}

 <script>
    $(document).ready(function() {
        $('.select2Dropdown').select2({ placeholder: 'Select an option' });

        $('.datatableDisplay').DataTable({
            drawCallback: function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
            language: {
                searchPlaceholder: "Enter to search ...",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
        });
    });

 </script>

 <!-- /core JS files -->
@yield('center-scripts')
 <!-- Theme JS files -->
 <script src="{{URL::asset('assets/js/app.js')}}"></script>
 <!-- /theme JS files -->
@yield('scripts')
