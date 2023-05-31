
@extends('layout.forms')

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-cogs"></i> User <small>Maintenance</small>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4 ">
                
                @if(Session::has('success'))

                <script>
                    setTimeout(function(){ $('#success').fadeOut();
                    }, 3000 );
                </script>

                <div id="success" class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><span class="fa fa-check-square-o"></span> Success!</strong> {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))

                <script>
                    setTimeout(function(){ $('#error').fadeOut();
                    }, 3000 );
                </script>
                <div id="error" class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><span class="fa fa-warning"></span> Error!</strong> {{ Session::get('error') }}
                </div>

                @endif

                
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="fa fa-users font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> User Form </span>
                        </div>
                        <a class="btn btn-sm blue pull-right" href="{{ route('maintenance.user.edit')}}">Add New</a>
                    </div>
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-12 well">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="search" id="search" placeholder="Search Employee ( Last Name, First Name)" disabled readonly />

                                    <input class="form-control" type="text" id="searchemp" placeholder="Search Employee"/>
                                      <span><img style="display: none;" id="emp_spinner" class="wd-15p mg-t-1" src="{{ asset('assets/apps/img/spinner/spinner5.gif') }}" height="50" width="150" alt=""></span>
                                </div>
                                <div id="result"></div>
                                <div id="employee_list"></div> 
                            </div>
                            <form action="{{route('maintenance.user.change')}}" method="post">
                                {{ method_field('PUT') }}
                                @csrf
                                 <div class="col-md-12" id="editemp" style="display: block;">

                                    {{-- @if(isset($name) || isset($dept)) --}}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="" class="control-label">Full Name</label>

                                            {{-- @if(isset($name)) --}}
                                                
                                                <input readonly type="text" name="firstName" id="fullname" class="form-control" value="{{$name}}">

                                            {{-- @elseif(!isset($name)) --}}

                                                {{-- <input readonly type="text" placeholder="First Name" name="firstName" id="fullname" class="form-control" /> --}}

                                            @endif

                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Department</label>

                                            {{-- @if(isset($dept)) --}}

                                                <input readonly type="text" class="form-control" name="dept" id="department" value="{{$dept}}">

                                            {{-- @elseif(!isset($dept)) --}}

                                                {{-- <input readonly type="text" placeholder="Department" name="dept" id="department" class="form-control" /> --}}

                                            {{-- @endif --}}

                                        </div>
                                    </div>

                                    {{-- @endif --}}

                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                            @if(isset($domain)) 

                                                <label class="control-label">Domain</label>
                                                <input required type="text" class="form-control" name="domain" value="{{$domain}}">
                                            
                                            @endif  
                                            {{-- @elseif(isset($name)) --}}

                                                <label class="control-label">Domain</label>
                                                <input required type="text" class="form-control" name="domain">
                                                                                
                                        </div>
                                        <div class="col-md-6">

                                        @if(isset($role))

                                            <label class="control-label">Role</label>
                                            <select required class="form-control" name="u_role">

                                                @if($role == 'requestor')

                                                <option value="{{$role}}">{{$role}}</option>
                                                <option value="approver">APPROVER</option>
                                                <option value="admin">ADMIN</option> 


                                                @elseif($role == 'approver')

                                                <option value="{{$role}}">{{$role}}</option>
                                                <option value="admin">ADMIN</option>
                                                <option value="requestor">REQUESTOR</option>

                                                

                                                @elseif($role == 'admin')
                                                
                                                <option value="{{$role}}}">{{$role}}</option>
                                                <option value="requestor">REQUESTOR</option>
                                                <option value="approver">APPROVER</option> 
                                                
                                                @endif

                                            </select>

                                        @endif

                                        {{-- @elseif(isset($name)) --}}
                                            
                                            <label class="control-label">Role</label>
                                            <select required class="form-control" name="u_role">
                                            <option value="">-- Select Role --</option>
                                            <option value="requestor">REQUESTOR</option>
                                            <option value="approver">APPROVER</option>
                                            <option value="admin">ADMIN</option>
                                           </select>
                                                                            
                                        

                                        </div>
                                    </div>
                                    <br/>

                                    @if(Request::get('id'))

                                    <div class="row">
                                        <button class="btn purple pull-right" type="submit" name="e_user">
                                            <span class="glyphicon glyphicon-edit"></span> Update
                                        </button>
                                    </div>
                                    
                                    @else

                                    <button class="btn blue pull-right" type="submit" name="a_user">
                                        <span class="glyphicon glyphicon-send"></span> Submit
                                    </button>

                                    @endif

                                </div>
                            </form>                          
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="emp_tbl"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <div class="col-md-8 ">
                <div class="row">
                    <div class="col-md-12">
                        


                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="fa fa-users font-dark"></i>
                                    <span class="caption-subject bold uppercase"> Users List</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Domain</th>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Is Lock</th>
                                            <th width="170px"></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User</th>
                                            <th>Domain</th>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Is Lock</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($userList as $item)
                                        <tr>
                                            <td>{{ ucwords($item->fullname) }}</td>
                                            <td>{{ ucwords($item->domain) }}</td>
                                            <td>{{ ucwords($item->dept) }}</td>
                                            <td>{{ ucwords($item->role) }}</td>
                                            <td>
                                                <center>
                                                    @if( $item->isLocked == 1)
                                                    <a title='Unlock User' data-toggle='modal' class='btn btn-circle btn-icon-only red' href='#unlock{{$item->id}}'>
                                                        <span class='fa fa-lock'></span>
                                                    </a>
                                                    @elseif(! $item->isLocked == 1)
                                                    <a title='Lock User' data-toggle='modal' class='btn btn-circle btn-icon-only green' href='#lock{{$item->id}}'>
                                                        <span class='fa fa-unlock'></span>
                                                    </a>
                                                    @endif
                                                </center>
                                                
                                                <div class="modal fade" id="unlock{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.user.update')}}" method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to <b>Unlock</b> this user?</div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="unlock_user" class="btn btn-circle green"><span class="fa fa-key"></span> Unlock</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="lock{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.user.update')}}" method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to <b>Lock</b> this user? </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="lock_user" class="btn btn-circle green"><span class="fa fa-key"></span> Lock</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                <td>

                                                <a class="btn btn-circle btn-sm blue" href="{{Request::url()}}?id={{$item->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                   
                                                    @if($item->active == 1)

                                                    <a class="btn btn-circle btn-sm green" data-toggle="modal" href="#inactive{{$item->id}}">
                                                        <i class="fa fa-check"></i> Active
                                                    </a>
                                                    <div class="modal fade" id="inactive{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form action="{{route('maintenance.user.update')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                    </div>
                                                                    <div class="modal-body"> Are you sure you want to <b>Deactivate</b> this user? </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="deactivate" class="btn btn-circle red">Deactivate</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    
                                                    @elseif(! $item->active == 1)
                                                    
                                                    <a class="btn btn-circle btn-sm red" data-toggle="modal" href="#active{{$item->id}}">
                                                        <i class="fa fa-close"></i> Inactive
                                                    </a>

                                                    <div class="modal fade" id="active{{$item->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form action="{{route('maintenance.user.update')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                    </div>
                                                                    <div class="modal-body"> Are you sure you want to <b>Activate</b> this user? </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="activate" class="btn btn-circle blue">Activate</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                    @endif
                                                </td>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

@endsection



@push('javascript')
<script>
    jQuery(document).ready(function() {    
       Metronic.init(); // init metronic core components
       Layout.init(); // init current layout
       TableManaged.init();
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

</script>

<script>

    $(document).ready(function(){

    var typingTimer;

    $('#searchemp').keydown(function(){
        $('#emp_spinner').show();
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingEmployee, 2000);
    });

    //   $('#e_search').keydown(function(){
    //     $('#e_emp_spinner').show();
    //     clearTimeout(typingTimer);
    //     typingTimer = setTimeout(e_doneTypingEmployee, 2000);
    // });

    function doneTypingEmployee(){
        var query = $('#searchemp').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('search.hris.employee') }}",
            method: "POST",
            data: { query :query, _token:_token },
            success: function(data)
            {
                $('#emp_spinner').hide();
                $('#employee_list').fadeIn();
                $('#employee_list').html(data);
            }
        })
    }

    //    function e_doneTypingEmployee(){
    //     var query = $('#e_search').val();
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: "{{ route('e_search.e_hris.e_employee') }}",
    //         method: "POST",
    //         data: { query :query, _token:_token },
    //         success: function(data)
    //         {
    //             $('#e_emp_spinner').hide();
    //             $('#e_employee_list').fadeIn();
    //             $('#e_employee_list').html(data);
    //         }
    //     })
    // }

    });

    $(document).on('click','.emp_list',function(){
    var emp = $(this).text();
    var i = emp.split("=");    

    $('#searchemp').val(i[0]);
    $('#employee_id').val(i[1]);
    $('#first_name').val(i[2]);
    $('#middle_name').val(i[3]);
    $('#last_name').val(i[4]);
    $('#companyid').val(i[5]);
    $('#department').val(i[6]);
    $('#position').val(i[7]);
    $('#fullname').val(i[8]);
    $('#employee_list').fadeOut();
    // $('#addemp').fadeIn();
    });  

     // $(document).on('click','#editemp',function(){
     // $('#editemp').fadeIn();
     // });

    // $(document).on('click','.e_emp_list',function(){
    // var emp = $(this).text();
    // var i = emp.split("=");    

    // $('#e_search').val(i[0]);
    // $('#e_employee_id').val(i[1]);
    // $('#e_first_name').val(i[2]);
    // $('#e_middle_name').val(i[3]);
    // $('#e_last_name').val(i[4]);
    // $('#e_companyid').val(i[5]);
    // $('#e_department').val(i[6]);
    // $('#e_position').val(i[7]);
    // $('#e_fullname').val(i[8]);
    // $('#e_employee_list').fadeOut();

    // });   

    </script>

@endpush