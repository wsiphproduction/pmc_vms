@extends('layout.dispatch')

@section('content')

   <div style="margin-left:150px;" class="col-md-10">

   <!-- BEGIN SAMPLE FORM PORTLET-->
   <div class="portlet light bordered">
      <div class="portlet-title">
            <div class="caption font-red-sunglo">
               <i class="fa fa-automobile font-red-sunglo"></i>
               <span class="caption-subject bold uppercase"> Update Dispatch Form </span>
            </div>
      </div>
      <div class="portlet-body">
            <div class="tab-content">
               <!-- PERSONAL INFO TAB -->
               <input type="hidden" id="tid" value="{{ $id }}">
            <div id="disptachTable" class="tab-pane active"></div>

         </div>
      </div>
   </div>
   <!-- END SAMPLE FORM PORTLET-->
      
   </div>
    
@endsection

@push('metronic-scripts')
    <script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

    <script src="{{ asset('metronic/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('metronic/datepicker/js/jquery-1.8.3.min.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('metronic/datepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/comments.js') }}"></script>
@endpush

@push('javascript')

    <script>
       $(document).ready(function() {
          showDispatch();
       });

       function showDispatch() {
          $id = $('#tid').val();
          $.ajax({
             url: "{!! route('vehicle.request.edit.dispatch_details_form', ['id' => $id]) !!}",
             type: 'GET',
             async: false,
             data: {
                dispatch: 1,
                id: $id,
                /*_token: '{!! csrf_token() !!}',*/
             },
             success: function(response) {
                console.log(response);
               $('#disptachTable').html(response);
             },
             error: function(error) {
                console.log(error)
             }
          });
       }

       (function($) {
          $(function() {

             var addFormGroup = function(event) {
                event.preventDefault();

                var $formGroup = $(this).closest('.form-group');
                var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                var $formGroupClone = $formGroup.clone();
                $(this)
                   .toggleClass('btn-default btn-add btn-danger btn-remove')
                   .html('x');
                $formGroupClone.find('input').val('');
                $formGroupClone.insertAfter($formGroup);
             };


             var removeFormGroup = function(event) {
                event.preventDefault();

                if (confirm('Are you sure you want to remove this passenger? ')) {
                   var $formGroup = $(this).closest('.form-group');
                   var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                   $formGroup.remove();
                } else {

                }
             };

             $(document).on('click', '.btn-add', addFormGroup);
             $(document).on('click', '.btn-remove', removeFormGroup);
          });
       })
       (jQuery);


       jQuery(document).ready(function() {
          Metronic.init(); // init metronic core components
          Layout.init(); // init current layout
          ComponentsDropdowns.init();

       });
    </script>

@endpush
