
@extends('layout.forms')

@section('content')
<div class="content">
    <div class="page-content-wrapper">
        <div class="page-content">
            {{-- CONTENT --}}
            <div class="row">
                <div class="col-md-12 col-sm-12">                    

                    <iframe src="{{ route('maintenance.unit.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto" height="550"></iframe>          

                </div>
             </div>

             <div class="row">
                <div class="col-md-4 col-sm-4">

                    <iframe src="{{ route('maintenance.mechanic.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto" height="550"></iframe>         
                      
                </div>
                <div class="col-md-4 col-sm-4">
                   
                    <iframe src="{{ route('maintenance.status.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto" height="500"></iframe>
                      
                </div>
                <div class="col-md-4 col-sm-4">
                   
                    <iframe src="{{ route('maintenance.assigned.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto" height="500"></iframe>
                     
                </div>                  
             </div>

             <div class="row">
                <div class="col-md-6 col-sm-6">
                  
                    <iframe src="{{ route('maintenance.preventive.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto"  height="500"></iframe>
                      
                </div>
                <div class="col-md-6 col-sm-6">
                   
                    <iframe src="{{ route('maintenance.breakdown.index') }}" style="overflow : hidden;" frameborder="0" width="100%" scrolling="auto"  height="500"></iframe>
                      
                </div>                  
             </div>
            {{-- CONTENT --}}
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
    jQuery(document).ready(function() {    
       Metronic.init(); // init metronic core components
       Layout.init(); // init current layout
       TableManaged.init();
       TableManaged1.init();
    });
 </script>
 <script>
   let TableManaged = function () {

       let initTable1 = function () {

            let table = $('#sample_1');

            // begin first table
            table.dataTable({
                "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true                    
                }, {
                    "orderable": true
                }, {
                    "orderable": false
                }],
                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 5,            
                "pagingType": "bootstrap_full_number",
                "language": {
                    "lengthMenu": "  _MENU_ records",
                    "paginate": {
                        "previous":"Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
                "columnDefs": [{  // set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [0, "desc"]
                ] // set first column as a default sort by asc
            });

            let tableWrapper = jQuery('#sample_1_wrapper');

            table.find('.group-checkable').change(function () {
                let set = jQuery(this).attr("data-set");
                let checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                        $(this).parents('tr').addClass("active");
                    } else {
                        $(this).attr("checked", false);
                        $(this).parents('tr').removeClass("active");
                    }
                });
                jQuery.uniform.update(set);
            });

            table.on('change', 'tbody tr .checkboxes', function () {
                $(this).parents('tr').toggleClass("active");
            });

            tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
        }

        return {
            //main function to initiate the module
            init: function () {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();
            }
        };

    }();

    let TableManaged1 = function () {

       let initTable1 = function () {

           let table = $('#sample_2');

           // begin first table
           table.dataTable({
               "columns": [{
                   "orderable": true
               }, {
                   "orderable": true
               }, {
                   "orderable": true                    
               }, {
                   "orderable": true
               }, {
                   "orderable": false
               }],
               "lengthMenu": [
                   [5, 15, 20, -1],
                   [5, 15, 20, "All"] // change per page values here
               ],
               // set the initial value
               "pageLength": 5,            
               "pagingType": "bootstrap_full_number",
               "language": {
                   "lengthMenu": "  _MENU_ records",
                   "paginate": {
                       "previous":"Prev",
                       "next": "Next",
                       "last": "Last",
                       "first": "First"
                   }
               },
               "columnDefs": [{  // set default column settings
                   'orderable': false,
                   'targets': [0]
               }, {
                   "searchable": false,
                   "targets": [0]
               }],
               "order": [
                   [0, "desc"]
               ] // set first column as a default sort by asc
           });

           let tableWrapper = jQuery('#sample_1_wrapper');

           table.find('.group-checkable').change(function () {
               let set = jQuery(this).attr("data-set");
               let checked = jQuery(this).is(":checked");
               jQuery(set).each(function () {
                   if (checked) {
                       $(this).attr("checked", true);
                       $(this).parents('tr').addClass("active");
                   } else {
                       $(this).attr("checked", false);
                       $(this).parents('tr').removeClass("active");
                   }
               });
               jQuery.uniform.update(set);
           });

           table.on('change', 'tbody tr .checkboxes', function () {
               $(this).parents('tr').toggleClass("active");
           });

           tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
       }

       return {
           //main function to initiate the module
           init: function () {
               if (!jQuery().dataTable) {
                   return;
               }
               initTable1();
           }
       };

       }();
 </script>
@endpush