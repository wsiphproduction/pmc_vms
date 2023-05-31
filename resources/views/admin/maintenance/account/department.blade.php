@extends('layout.forms')

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-cogs"></i> Department User <small>Maintenance</small>
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
                            <span class="caption-subject bold uppercase"> User Form</span>
                        </div>
                        @if($create)
                        <a class="btn btn-sm blue pull-right" href="{{route('maintenance.dept')}}">Add New</a>
                        @else
                        <button disabled class="btn btn-sm blue pull-right" href="{{route('maintenance.dept')}}">Add New</button>
                        @endif
                    </div>
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-12 well">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="search" id="search"
                                        placeholder="Search Department" disabled readonly />
                                                                              
                                        <input class="form-control" type="text" id="searchdept" placeholder="Search Department"/>
                                              <span><img style="display: none;" id="dept_spinner" class="wd-15p mg-t-1" src="{{ asset('assets/apps/img/spinner/spinner5.gif') }}" height="50" width="150" alt=""></span> 
                                </div> 
                                <div id="result"></div>  
                                <div id="department_list"></div>                                
                            </div>
                            <form action="{{route('maintenance.dept.update')}}" method="post">
                                @csrf
                                <div class="col-md-12" id="adddept" style="display: block;">

                                    <input type="hidden" name="id" value="{{ request()->query('id') }}">
                                    
                                    @if(isset($dept))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Department</label>

                                            
                                            @if(isset($dept))

                                                <input readonly type="text" class="form-control" name="dept" id="department" value="{{$dept}}">

                                            @else

                                                <input readonly type="text" placeholder="Department" name="dept" id="department" class="form-control" />

                                            @endif
                                        </div>

                                    </div>

                                    @else

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Department</label>
                                         

                                            <input readonly type="text" placeholder="Department" name="dept" id="dept"
                                                class="form-control" />
                                            
                                        </div>

                                    </div>

                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                        <label class="control-label">Role</label>
                                            <select required name="role_id" id="role_id" class="form-control">
                                                @foreach($roles as $role)
                                                <option value="{{ $role['id'] }}" {{ ($role['id'] == $roleid) ? 'selected' : '' }}>{{ $role['name'] }}</option>
                                                @endforeach
                                            </select>                                           
                                        </div>

                                        <div class="col-md-6">

                                            @if(isset($dpassword))

                                            <label class="control-label">Password</label>
                                            <input required type="password" class="form-control" name="dpassword"
                                                value="{{$dpassword}}">

                                            @else                                    

                                            <label class="control-label">Password</label>
                                            <input required type="password" class="form-control" name="dpassword">

                                            @endif    

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        @if(Request::get('id'))
                                        
                                            @if($edit)
                                                <button class="btn purple pull-right" type="submit" name="e_user">
                                                    <span class="glyphicon glyphicon-edit"></span> Update
                                                </button>
                                            @else
                                                <button disabled class="btn purple pull-right" type="submit" name="e_user">
                                                    <span class="glyphicon glyphicon-edit"></span> Update
                                                </button>
                                            @endif

                                        @else

                                            @if($create)
                                                <button class="btn blue pull-right" type="submit" name="a_user">
                                                    <span class="glyphicon glyphicon-send"></span> Submit
                                                </button>
                                            @else
                                                <button disabled class="btn blue pull-right" type="submit" name="a_user">
                                                    <span class="glyphicon glyphicon-send"></span> Submit
                                                </button>
                                            @endif

                                        @endif
                                    </div>
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
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->

                        @if(isset($successMsg))

                        <script>
                            setTimeout(function(){ $('#success').fadeOut();
                            }, 3000 );
                        </script>

                        <div id="success" class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><span class="fa fa-check-square-o"></span> Success!</strong>
                            {{ Session::get('successMsg') }}
                        </div>

                        @elseif(isset($errorMsg))

                        <script>
                            setTimeout(function(){ $('#error').fadeOut();
                            }, 3000 );
                        </script>

                        <div id="error" class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><span class="fa fa-warning"></span> Error!</strong>{{ Session::get('errorMsg') }}
                        </div>

                        @endif

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="fa fa-users font-dark"></i>
                                    <span class="caption-subject bold uppercase"> Department Users List</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_101">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Lock/Unlock</th>
                                            <th width="170px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Is Lock</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($userList as $item)
                                        <tr>
                                            <td>{{ ucwords($item->dept) }}</td>
                                            <td>{{ ucwords($item->role) }}</td>
                                            <td>
                                                <center>

                                                    @if( $item->isLocked == 1)
                                                    @if($edit)
                                                    <a title='Unlock User' data-toggle='modal'
                                                        class='btn btn-circle btn-icon-only red'
                                                        href='#unlock{{$item->id}}'>
                                                        <span class='fa fa-lock'></span>
                                                    </a>
                                                    @else
                                                    <button disabled title='Unlock User' data-toggle='modal'
                                                        class='btn btn-circle btn-icon-only red'
                                                        href='#unlock{{$item->id}}'>
                                                        <span class='fa fa-lock'></span>
                                                    </button>
                                                    @endif

                                                    @elseif(! $item->isLocked == 1)
                                                    @if($edit)
                                                    <a title='Lock User' data-toggle='modal'
                                                        class='btn btn-circle btn-icon-only green'
                                                        href='#lock{{$item->id}}'>
                                                        <span class='fa fa-unlock'></span>
                                                    </a>
                                                    @else
                                                    <button disabled title='Lock User' data-toggle='modal'
                                                        class='btn btn-circle btn-icon-only green'
                                                        href='#lock{{$item->id}}'>
                                                        <span class='fa fa-unlock'></span>
                                                    </button>
                                                    @endif

                                                    @endif

                                                </center>

                                                <div class="modal fade" id="unlock{{$item->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.dept.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$item->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Unlock</b> this user? </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-circle dark btn-outline"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="unlock_user"
                                                                        class="btn btn-circle green"><span
                                                                            class="fa fa-key"></span> Unlock</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="lock{{$item->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.dept.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$item->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Lock</b> this user? </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-circle dark btn-outline"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="lock_user"
                                                                        class="btn btn-circle red"><span
                                                                            class="fa fa-lock"></span> Lock</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm blue"
                                                    href="{{Request::url()}}?id={{$item->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm blue"
                                                    href="{{Request::url()}}?id={{$item->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                @endif
                                                @if($item->active == 1)
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm green" data-toggle="modal"
                                                    href="#inactive{{$item->id}}">
                                                    <i class="fa fa-check"></i> Active
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm green" data-toggle="modal"
                                                    href="#inactive{{$item->id}}">
                                                    <i class="fa fa-check"></i> Active
                                                </button>
                                                @endif

                                                <div class="modal fade" id="inactive{{$item->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.dept.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$item->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Deactivate</b> this user? </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-circle dark btn-outline"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="deactivate"
                                                                        class="btn btn-circle red">Deactivate</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                @elseif(! $item->active == 1)
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm red" data-toggle="modal"
                                                    href="#active{{$item->id}}">
                                                    <i class="fa fa-close"></i> Inactive
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm red" data-toggle="modal"
                                                    href="#active{{$item->id}}">
                                                    <i class="fa fa-close"></i> Inactive
                                                </button>
                                                @endif
                                                <div class="modal fade" id="active{{$item->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.dept.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$item->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Activate</b> this user? </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-circle dark btn-outline"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="activate"
                                                                        class="btn btn-circle blue">Activate</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                @endif

                                            </td>
                                        </tr>

                                        @empty

                                        <tr>
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
<script type="text/javascript">
    function showdept(x) {

        let deptrec = x.split('|');
        // alert(x);
        // console.log(deptrec[1]);
        $('#depart_ment').val(deptrec[1]); //this syntax is for id
        // $('input[name$=depart_ment]').val( deptrec[1] ); // this syntax is for name
    }

    $(document).ready(function() {
        $('#search').on('keyup', function() {

            if ($("#search").val() == "") {
                $('#result').empty();
            } else {
                let search = $("#search").val();
                let http = '{!! route('searchdept') !!}';
                $.ajax({
                    url: http,
                    type: 'POST',
                    data: {
                        search: search
                    },
                    dataType: 'text',
                    success: function(data) {
                        $("#result").html(data);
                    }
                });
            }
        });
    });
</script>
<script>

    $(document).ready(function(){

    var typingTimer;

    $('#searchdept').keydown(function(){
        $('#dept_spinner').show();
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingDepartment, 2000);
    });

    //   $('#e_search').keydown(function(){
    //     $('#e_emp_spinner').show();
    //     clearTimeout(typingTimer);
    //     typingTimer = setTimeout(e_doneTypingEmployee, 2000);
    // });

    function doneTypingDepartment(){
        var query = $('#searchdept').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('search.hris.department') }}",
            method: "POST",
            data: { query :query, _token:_token },
            success: function(data)
            {
                $('#dept_spinner').hide();
                $('#department_list').fadeIn();
                $('#department_list').html(data);                
            }
        })
    }

    //    function e_doneTypingEmployee(){
    //     var query = $('#e_search').val();
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: "{{ route('e_search.e_hris.e_department') }}",
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

    $(document).on('click','.dept_list',function(){
    var emp = $(this).text();
    var i = emp.split("=");    

    $('#searchdept').val(i[0]);
    $('#dept').val(i[0]);
    $('#department_list').fadeOut();
    // $('#adddept').fadeIn();
    });  

    // $(document).on('click','.e_dept_list',function(){
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