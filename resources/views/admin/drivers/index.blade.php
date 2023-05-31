@extends('layout.vehicle_utilization.reports')

@section('content')
<div class="clearfix"></div>
      <!-- BEGIN CONTAINER -->
      <div class="page-container">
         <!-- BEGIN CONTENT -->
         <div class="page-content-wrapper">
            <div class="page-content">
              
               @if( request()->get('status') == 'created' )
               <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Record Added</strong>
               </div>

                @elseif( request()->get('status') == 'updated' )
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Record Updated</strong>
                </div>


               @elseif( request()->get('status') == 'enabled' )
               <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Record Activated</strong>
               </div>
                
               @elseif( request()->get('status') == 'disabled' )
               <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Record Deactivated</strong>
               </div>
               @endif
               
               <div class="modal fade" id="modal-add">
                  <div class="modal-dialog">
                     <div class="modal-content">
                     <form action="{{ route('driver.create') }}" method="POST" class="form-inline" role="form">
                        @csrf
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                           <h4 class="modal-title">New Driver</h4>
                        </div>
                        <div class="modal-body">
                              <div class="form-group">
                                 <label for="">Name:</label>
                                 <input type="text" class="form-control" id="dname" name="dname" placeholder="Last, First MI" required maxlength="50">
                              </div>  
                              <br><br>
                              <div class="form-group">
                                 <label for="">Type:&nbsp;</label>
                                 
                                 <select name="dtype" id="dtype" class="form-control" placeholder="Select..">
                                 <option value="">Select..</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                 </select>
                                 
                              </div>  
                              <div class="form-group">
                                 <label for=""> OR Add New: </label>
                                 <input type="text" class="form-control" id="dtype2" name="dtype2" placeholder="New Type" required maxlength="30">
                              </div> 
                              
                           
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                     </form>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="modal-edit">
                  <div class="modal-dialog">
                     <div class="modal-content">
                     <form id="edit-form" action="" method="POST" class="form-inline" role="form">
                        @csrf
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                           <h4 class="modal-title">Update Driver</h4>
                        </div>
                        <div class="modal-body">
                              <div class="form-group">
                                 <label for="">Name:</label>
                                 <input type="text" class="form-control" id="edname" required name="edname" placeholder="Last, First MI" required maxlength="50">
                                 <input type="hidden" value="" required name="edid" id="edid">
                              </div>  
                              <br><br>
                              <div class="form-group">
                                 <label for="">Type:&nbsp;</label>
                                 
                                 <select name="edtype" id="edtype" class="form-control" placeholder="Select..">
                                    <option value="">Select..</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                 </select>
                              </div>  
                              <div class="form-group">
                                 <label for=""> OR Add New: </label>
                                 <input type="text" class="form-control" id="edtype2" name="edtype2" placeholder="New Type" required maxlength="30">
                              </div> 
                              
                           
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                     </form>
                     </div>
                  </div>
               </div>
               <div class="row margin-bottom-10">
                  <div class="col-md-2 pull-left"><span style="font-size:15px;"><input type="checkbox" name="filter" id="filter"> Filter</span></div>
                 
                  <div class="col-md-10 text-right">
                     <div>
                        <a class="btn blue btn-sm" href="#" style="margin-left: 10px;" onclick="$('#modal-add').modal('show');">
                          <span class="fa fa-plus"></span> Add New
                        </a>
                        <a class="btn green btn-sm" href="/drivers/export" style="margin-left: 10px;">
                           <span class="fa fa-download"></span> Download List
                        </a>                       
                     </div> 
                  </div>
               </div>  
               <div class="row">                  
                  <div class="col-md-12">                     
                     <div class="clearfix"></div>
                     <table style="font-size:12px;" class="table table-striped table-bordered table-hover js-dynamitable">
                        <thead id="nofilter_head">                                    
                           <tr>
                              <th style="font-size:11px;">Name </th>
                              <th style="font-size:11px;">Type </th>                          
                              <th style="font-size:11px;">Action </th>                                    
                           </tr>                                  
                        </thead>
                        <thead id="filter_head" style="display:none;">
                           
                           <tr>
                              <th style="font-size:11px;">Name <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                              <th style="font-size:11px;">Type <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                              <th style="font-size:11px;">Action <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                              </tr>
                           <tr>
                              <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                              <th><input class="js-filter  form-control input-sm" type="text" value=""></th>

                                                            
                           </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->driver_name }}</td>
                                    <td>{{ $driver->type }}</td>
                                    <td>{!! $driver->actions !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                     </table>

                     
                  </div>                   
               </div>
               <div class="clearfix">
               </div>      
            </div>
         </div>
         <!-- END CONTENT -->
      </div>
@endsection
    <script> 
        function exportToExcel(table){
        jQuery(table).table2excel({
            name: "VMS",
            filename: "VMS" //do not include extension
        }); 
        }
    </script>

    <script>
        jQuery(document).ready(function() {    
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        ComponentsPickers.init();
        
        });
    </script>

<script>
   $("#filter").click( function(){
      if( $(this).is(':checked') ) {
         $('#filter_head').show();
         $('#nofilter_head').hide();
      }
      else{
         $('#nofilter_head').show();
         $('#filter_head').hide();
      }
   });
 
   function edit(x){
      var y = $('#driver'+x).val();
      
      var d = y.split("|");
      //alert(y);
      
      $('#edid').val(d[0]);
      $('#edname').val(d[1]);
      $('#edtype').val(d[2]);

      $('#modal-edit').modal('show');
      $('#edit-form').attr('action', `/drivers/${d[0]}/update`);
   }

   function disable_driver(x){
      var r = confirm("Are you sure you want to disable this driver?");
      if (r == true) {
         r = 0;
         window.location.href = `/drivers/${x}/active?active=${r}`;
      } else {
         return false;
      }
      
   }
</script>
@section('javascript')