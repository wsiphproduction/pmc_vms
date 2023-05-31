@extends('layout.forms')

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-cogs"></i> Role Access Rights <small>Maintenance</small>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">

            <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->

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
                            <div class="caption font-red-sunglo">
                                <i class="fa fa-users font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase"> Roles List</span>
                            </div>                            
                        </div>

                        <form id="form" action="{{ route('maintenance.roleaccessrights.store') }}" method="POST">

                            <input type="hidden" name="roles_permissions" id="roles_permissions" value="">
                            @csrf


                            <div class="actions">
                                <div class="form-group form-inline" style="display:inline;margin-right:10px">
                                    <label class="control-label" style="margin-right:20px; margin-left:20px">Role </label>

                                    <select required name="roleid" id="roleid" class="form-control">
                                        @foreach($roles as $role)
                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @if($create)
                                <button type="submit" class="btn blue" id="saveRolePermission">
                                    <i class="fa fa-save"></i>&nbsp; Save Changes
                                </button>
                                @else
                                <button disabled type="submit" class="btn blue" id="saveRolePermission">
                                    <i class="fa fa-save"></i>&nbsp; Save Changes
                                </button>
                                @endif
                            </div>
                        </form>                        
                        &nbsp; 
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Permission List
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> View
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Create
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Update
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Delete/Cancel
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Print
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Upload
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Permission List
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> View
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Create
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Update
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Delete/Cancel
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Print
                                        </th>
                                        <th>
                                            <i class="fa fa-briefcase"></i> Upload
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($modules as $module)
                                    <tr>
                                        <td width="50%">
                                            <div class="caption custom-padding">
                                                <span class="caption-subject font-green bold uppercase">{{ strtoupper($module['description'])}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_view" data-module="{{$module['id']}}_view" onclick="checkPermission(this.id)" id="{{$module['id']}}_view">
                                                <label for="{{$module['id']}}_view">
                                                    <span></span>
                                                    <span span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_create" data-module="{{$module['id']}}_create" onclick="checkPermission(this.id)" id="{{$module['id']}}_create">
                                                <label for="{{$module['id']}}_create">
                                                    <span></span>
                                                    <span span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_edit" data-module="{{$module['id']}}_edit" id="{{$module['id']}}_edit" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_edit">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_delete" data-module="{{$module['id']}}_delete" id="{{$module['id']}}_delete" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_delete">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_print" data-module="{{$module['id']}}_print" id="{{$module['id']}}_print" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_print">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_upload" data-module="{{$module['id']}}_upload" id="{{$module['id']}}_upload" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_upload">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($permissions as $permission)
                                    @if(strtoupper($permission['module_type']) == strtoupper($module['description']) )
                                    <tr>
                                        <td>
                                            {{ strtoupper($permission['description']) }}
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_view" data-module="{{$permission['id']}}_{{$module['id']}}_view" id="{{$permission['id']}}_{{$module['id']}}_view" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_view">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_create" data-module="{{$permission['id']}}_{{$module['id']}}_create" id="{{$permission['id']}}_{{$module['id']}}_create" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_create">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_edit" data-module="{{$permission['id']}}_{{$module['id']}}_edit" id="{{$permission['id']}}_{{$module['id']}}_edit" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_edit">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_delete" data-module="{{$permission['id']}}_{{$module['id']}}_delete" id="{{$permission['id']}}_{{$module['id']}}_delete" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_delete">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_print" data-module="{{$permission['id']}}_{{$module['id']}}_print" id="{{$permission['id']}}_{{$module['id']}}_print" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_print">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_upload" data-module="{{$permission['id']}}_{{$module['id']}}_upload" id="{{$permission['id']}}_{{$module['id']}}_upload" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_upload">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach

                                </tbody>
                            </table>
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
    $(document).ready(function() {
        getRolesPermissions($("#roleid").val());
        $("#roleid").on('change', function() {
            getRolesPermissions($("#roleid").val());

        })
    });

    function getRolesPermissions(roleid) {
        document.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = false)
        $("#roles_permissions").val("");
        $.ajax({
            url: '{!! route('maintenance.roleaccessrights.store') !!}',
            type: 'get',

            data: {
                roleid: roleid
            },
            success: function(data) {
                $.each(data, function(index, element) {
                    var chkid = "";
                    chkid = (element.permission_id + "_" + element.module_id + "_" + element.action)
                    if (chkid != "") {
                        document.getElementById(element.module_id + "_" + element.action).checked = true;
                        document.getElementById(chkid).checked = true;

                        storeID(chkid);
                    }
                });
            }
        });
    }

    function checkPermission(id) {
        var checkboxes = document.getElementsByTagName("input");
        const cb = document.getElementById(id);
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == "checkbox") {
                if (checkboxes[i].id.includes(id)) {
                    document.getElementById(checkboxes[i].id).checked = cb.checked;
                    storeID(checkboxes[i].id);
                }
            }
        }
    }

    function storeID(id) {
        var roles_permissions = $("#roles_permissions").val();

        if (document.getElementById(id).checked) {
            if (roles_permissions != "") {

                roles_permissions = roles_permissions + ',' + id;
            } else {

                roles_permissions = id;
            }
        } else {
            if ((id.match(/_/g) || []).length == 2) {
                if (roles_permissions.includes("," + id)) {
                    roles_permissions = roles_permissions.replace("," + id, "");
                    console.log(roles_permissions);
                } else if (roles_permissions.includes(id + ",")) {
                    roles_permissions = roles_permissions.replace(id + ",", "");

                    console.log(roles_permissions);
                } else {
                    roles_permissions = roles_permissions.replace(id, "");
                }
            }
        }
        $("#roles_permissions").val(roles_permissions);
    }
</script>

@endpush