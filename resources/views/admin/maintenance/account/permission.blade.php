@extends('layout.forms')

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-cogs"></i> Permission <small>Maintenance</small>
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
                            <span class="caption-subject bold uppercase"> Permission Form</span>
                        </div>
                        @if($create)
                        <a class="btn btn-sm blue pull-right" href="{{route('maintenance.permission')}}">Add New</a>
                        @else
                        <button disabled class="btn btn-sm blue pull-right" href="{{route('maintenance.permission')}}">Add New</button>
                        @endif
                    </div>

                    <div class="portlet-body form">
                        <div class="row">                                
                                <form action="{{route('maintenance.permission.update')}}" method="post">
                                @csrf
                                <div class="col-md-12" id="addrole" style="display: block;">

                                    <input type="hidden" name="id" value="{{ request()->query('id') }}">
                                                                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Module <span class="required" aria-required="true"> * </span></label>                                                                                        
                                            @if(isset($permissions))

                                                <select onchange="disableTextbox()" class="form-control input-large select2me" name="module_type" id="module_type" data-placeholder="Select Module">   
                                                    <option value="{{ $permissions->module_type }}" selected>{{ ($permissions->module_type) }}</option>                 
                                                    <option value="">Select Module</option>  
                                                    @foreach($modules as $key => $mod) 
                                                    <option value="{{ $mod['description'] }}">{{ ($mod['description']) }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="check" id="check">

                                            @else

                                                <select onchange="disableTextbox()" class="form-control input-large select2me" name="module_type" id="module_type" data-placeholder="Select Moduel">                                                         
                                                    <option value="">Select Module</option>  
                                                    @foreach($modules as $key => $item)
                                                    <option value="{{ $item['description'] }}">{{ ($item['description']) }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="check" id="check">

                                            @endif
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Description <span class="required" aria-required="true"> * </span></label>                                                                                    
                                            @if(isset($permissions))
                                                <input type="text" class="form-control" name="description" id="description" required maxlength="50" value="{{$permissions->description}}"/>
                                            @else
                                                <input type="text" placeholder="Description" name="description" id="description" class="form-control" required maxlength="50" />
                                            @endif
                                        </div>
                                    </div>                                    
                                                                
                                    <br>
                                    <div class="row">
                                        
                                        @if(Request::get('id'))
                                            @if($edit)
                                            <button class="btn purple pull-right" type="submit" name="e_permission">
                                                <span class="glyphicon glyphicon-edit"></span> Update
                                            </button>
                                            @else
                                            <button disabled class="btn purple pull-right" type="submit" name="e_permission">
                                                <span class="glyphicon glyphicon-edit"></span> Update
                                            </button>
                                            @endif
                                        @else
                                            @if($create)
                                            <button class="btn blue pull-right" type="submit" name="a_permission">
                                                <span class="glyphicon glyphicon-send"></span> Submit
                                            </button>
                                            @else
                                            <button disabled class="btn blue pull-right" type="submit" name="a_permission">
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
                                    <span class="caption-subject bold uppercase"> Permissions List</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_101">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th width="170px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Module</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($permissionList as $permission)
                                        <tr>
                                            <td>{{ strtoupper($permission->module_type) }}</td>
                                            <td>{{ ($permission->description) }}</td>
                                            <td>
                                                @if($permission->active)
                                                <i class="font-blue"> Active</i>
                                                @else
                                                <i class="font-red"> Inactive</i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm blue"
                                                    href="{{Request::url()}}?id={{$permission->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm blue"
                                                    href="{{Request::url()}}?id={{$permission->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                @endif

                                                @if($permission->active == 1)
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm green" data-toggle="modal"
                                                    href="#inactive{{$permission->id}}">
                                                    <i class="fa fa-check"></i> Active
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm green" data-toggle="modal"
                                                    href="#inactive{{$permission->id}}">
                                                    <i class="fa fa-check"></i> Active
                                                </button>
                                                @endif

                                                <div class="modal fade" id="inactive{{$permission->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.permission.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$permission->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Deactivate</b> this permission? </div>
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

                                                @elseif(! $permission->active == 1)
                                                @if($edit)
                                                <a class="btn btn-circle btn-sm red" data-toggle="modal"
                                                    href="#active{{$permission->id}}">
                                                    <i class="fa fa-close"></i> Inactive
                                                </a>
                                                @else
                                                <button disabled class="btn btn-circle btn-sm red" data-toggle="modal"
                                                    href="#active{{$permission->id}}">
                                                    <i class="fa fa-close"></i> Inactive
                                                </button>
                                                @endif
                                                <div class="modal fade" id="active{{$permission->id}}" tabindex="-1"
                                                    role="basic" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('maintenance.permission.update')}}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden" name="id"
                                                                        value="{{$permission->id}}">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    <h4 class="modal-title"><b>Confirmation</b></h4>
                                                                </div>
                                                                <div class="modal-body"> Are you sure you want to
                                                                    <b>Activate</b> this permission? </div>
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


</script>

@endpush