@extends('layout.utilization')


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            @if(Request::has('added'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Record Added</strong>
            </div>
            
            @elseif(Request::has('updated'  ))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Record Updated</strong>
            </div>
            
            @elseif(Request::has('activated'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Record Deactivated</strong>
                <!-- <strong>Record Activated</strong> -->
            </div>
        
            @elseif(Request::has('deactivated'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Record Activated</strong>
                <!-- <strong>Record Deactivated</strong> -->
            </div>
            @endif

            <div class="modal fade" id="modal-add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('vehicle.drivers.submit', ['act' => 'submit'])}}" method="POST" class="form-inline" role="form">
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
                                        @foreach ($types as $item)
                                        <option value=" {{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for=""> OR Add New: </label>
                                    <input type="text" class="form-control" id="dtype2" name="dtype2" placeholder="New Type">
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
                        <form action="{{route('vehicle.drivers.submit', ['act' => 'update'])}}" method="POST" class="form-inline" role="form">
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
                                    
                                        @foreach ($types as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    

                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for=""> OR Add New: </label>
                                    <input type="text" class="form-control" id="edtype2" name="edtype2" placeholder="New Type">
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
                <div class="col-md-2 pull-left"><span style="font-size:15px;"><input type="checkbox" name="filter"
                            id="filter"> Filter</span></div>

                <div class="col-md-10 text-right">
                    <div>
                        @if($create)
                        <a class="btn blue btn-sm" href="#" style="margin-left: 10px;"
                            onclick="$('#modal-add').modal('show');">
                            <span class="fa fa-plus"></span> Add New
                        </a>
                        @else
                        <button disabled class="btn blue btn-sm" href="#" style="margin-left: 10px;"
                            onclick="$('#modal-add').modal('show');">
                            <span class="fa fa-plus"></span> Add New
                        </button>
                        @endif
                        <a class="btn green btn-sm" href="{{route('vehicle.request.export')}}" style="margin-left: 10px;">
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
                                <th style="font-size:11px;">Name <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                                    <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span> 
                                </th>
                                <th style="font-size:11px;">Type <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                                    <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span> 
                                </th>
                                <th style="font-size:11px;">Action <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                                    <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span> 
                                </th>
                            </tr>
                            <tr>
                                <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                                <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach ($drivers as $item)

                            <tr>             
                                <td>
                                    {{$item->driver_name}}
                                </td>     
                                <td>
                                    {{$item->type}}<input type="hidden" name="driver{{$item->id}}" id="driver{{$item->id}}" value="{{$item->id}}|{{$item->driver_name}}|{{$item->type}}">
                                </td>            
                                <td>
                                    @if($edit)
                                    <form action="{{route('vehicle.drivers.submit', ['act' => 'activate', 'id' => $item->id])}}" method="POST">
                                        @csrf

                                        <a href="#" onclick="edit({{$item->id}})" class="btn btn-xs green" >Edit</a>

                                    @if($item->isActive == 0)

                                        <button type="submit" class="btn btn-xs blue"onclick="return confirm('Are you sure you want to disable this driver?')">Enable</button>

                                    @else

                                    <a href="javascript:void(0)" class="btn btn-xs red" onclick="disable_driver({{$item->id}})">Disable</a>

                                    @endif
                                    @else
                                    <form action="{{route('vehicle.drivers.submit', ['act' => 'activate', 'id' => $item->id])}}" method="POST">
                                        @csrf

                                        <button disabled href="#" onclick="edit({{$item->id}})" class="btn btn-xs green" >Edit</button>

                                    @if($item->isActive == 0)

                                        <button disabled type="submit" class="btn btn-xs blue">Enable</button>

                                    @else

                                    <button disabled href="javascript:void(0)" class="btn btn-xs red" onclick="disable_driver({{$item->id}})">Disable</button>

                                    @endif
                                    @endif

                                    </form>
                                </td>
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
@endsection


@push('script')
<script>
    function exportToExcel(table) {
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
    $("#filter").click(function() {
        if ($(this).is(':checked')) {
            $('#filter_head').show();
            $('#nofilter_head').hide();
        } else {
            $('#nofilter_head').show();
            $('#filter_head').hide();
        }
    });

    function edit(x) {
        var y = $('#driver' + x).val();

        var d = y.split("|");
        //alert(y);
        $('#edid').val(d[0]);
        $('#edname').val(d[1]);
        $('#edtype').val(d[2]);

        $('#modal-edit').modal('show');
    }

    function disable_driver(x) {
        var r = confirm("Are you sure you want to enable this driver?");
        if (r == true) {
            // Dirty Implementation
            let link = "{!! route('vehicle.drivers.submit',['act' => 'deactivate']) !!}";
            link += "&id="+x;
            let csrf = $('meta[name="csrf-token"]').attr('content');
            document.body.innerHTML += '<form id="frm" action="'+link+'" method="post"><input type="hidden" name="_token" value="' + csrf+ '"></form>';
            document.getElementById("frm").submit();
        } else {
            return false;
        }

    }
</script>
@endpush