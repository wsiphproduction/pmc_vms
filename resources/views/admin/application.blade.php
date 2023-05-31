@extends('layout.forms')

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <br><br><br><br>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-cogs"></i> Application <small>Maintenance</small>
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
                            <span class="caption-subject bold uppercase"> Schedule Form</span>
                        </div>                        
                    </div>

                    <div class="portlet-title">
                        @if($create)
                        <a class="btn btn-sm blue pull-left" href="{{route('maintenance.application.index')}}">Create a Scheduled Shutdown </a>
                        @else
                        <button disabled class="btn btn-sm blue pull-left" href="{{route('maintenance.application.index')}}">Create a Scheduled Shutdown </button>
                        @endif
                    </div>


                    <div class="portlet-body form">
                        <div class="row">                                
                                <form action="{{route('maintenance.application.update')}}" method="post">
                                @csrf
                                <div class="col-md-12" id="addrole" style="display: block;">

                                    <input type="hidden" name="id" value="{{ request()->query('id') }}">
                                                                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Date</label><i class="font-red"> *</i>
                                            @if(isset($applications))
                                                <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                    <input required type="date" name="scheduled_date" id="scheduled_date" class="form-control" value="{{$applications->scheduled_date}}"/>
                                                </div> 
                                            @else
                                                <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                    <input required type="date" name="scheduled_date" id="scheduled_date" class="form-control" />
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Time</label><i class="font-red"> *</i>
                                            @if(isset($applications))
                                                <?php
                                                    $schedule_time = $applications['scheduled_time'];
                                                    $schedule_time = str_replace(':00.0000000','',$schedule_time);
                                                ?>
                                                <input required type="time" class="form-control" name="scheduled_time" id="scheduled_time" value="{{$schedule_time}}" />
                                                
                                            @else
                                                <input required type="time" name="scheduled_time" class="form-control" id="scheduled_time" />
                                            @endif                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Reason</label><i class="font-red"> *</i>
                                            @if(isset($applications))                                                
                                                <input type="text" class="form-control" name="reason" id="reason" value="{{$applications->reason}}" required maxlength="50"/>
                                            @else
                                                <input type="text" placeholder="Reason" name="reason" id="reason" class="form-control" required maxlength="50" />
                                            @endif                                            
                                        </div>
                                    </div>

                                                                
                                    <br>
                                    <div class="row">

                                        @if(Request::get('id'))
                                            @if($edit)
                                            <button class="btn purple pull-right" type="submit" name="e_application">
                                                <span class="glyphicon glyphicon-edit"></span> Update
                                            </button>
                                            @else
                                            <button disabled class="btn purple pull-right" type="submit" name="e_application">
                                                <span class="glyphicon glyphicon-edit"></span> Update
                                            </button>
                                            @endif
                                        @else
                                            @if($create)
                                            <button class="btn blue pull-right" type="submit" name="a_application">
                                                <span class="glyphicon glyphicon-send"></span> Submit
                                            </button>
                                            @else
                                            <button disabled class="btn blue pull-right" type="submit" name="a_application">
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
                                    <span class="caption-subject bold uppercase"> Scheduled Shutdown List</span>
                                </div>

                                <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-12" style="direction:rtl;">
                                        <div class="btn-group">
                                            <a onclick="return confirm('Are you sure you want to run reindexing?')" href="{{ route('maintenance.application.create_indexing') }}" class="btn sbold green"> Reindex Application Database</a>                                                    
                                        </div>
                                        <div class="btn-group">
                                            <a onclick="return confirm('Are you sure you want to start application?')" href="{{ route('maintenance.application.systemUp') }}" class="btn sbold blue"> Start</a>                                                    
                                        </div>
                                        <div class="btn-group">
                                            <a onclick="return confirm('Are you sure you want to stop application?')" href="{{ route('maintenance.application.systemDown') }}" class="btn sbold red"> Stop</a>                                                    
                                        </div>
                                    </div>
                                </div>
                                </div>                                
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_101">
                                    <thead>
                                        <tr>
                                            <th>Scheduled Date</th>
                                            <th>Scheduled Time</th>
                                            <th>Reason</th>
                                            <th width="200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Scheduled Date</th>
                                            <th>Scheduled Time</th>
                                            <th>Reason</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($applicationList as $application)
                                        <tr>
                                            <td>{{ ($application->scheduled_date) }}</td>
                                            <td>{{ ($application->scheduled_time) }}</td>
                                            <td>{{ ($application->reason) }}</td>

                                            <td>
                                            @if($edit)
                                                <a class="btn btn-circle btn-sm blue"
                                                    href="{{Request::url()}}?id={{$application->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a data-toggle="modal"  class="btn btn-sm red btn-outline filter-submit margin-bottom" href="#remove{{ $application['id' ]}}"><span class="fa fa-trash-o"></span> Remove</a>
                                            @else
                                                <button disabled class="btn btn-sm blue btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</button>
                                                <button disabled class="btn btn-sm red btn-outline filter-submit margin-bottom"><span class="fa fa-trash-o"></span> Remove</button>
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

    @foreach($applicationList as $application)
    
    <div class="modal fade" id="remove{{ $application['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('maintenance.application.destroy', $application['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><b>Confirmation</b></h4>
                    </div>
                    <div class="modal-body"> Are you sure you want to <b>Remove</b> this schedule? </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="submit" name="remove" class="btn btn-circle red"><span class="fa fa-trash"></span> Remove</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach    

@endsection


@push('javascript')
<script type="text/javascript">

    $(document).ready(function(){                
        });
    


          function systemDown(id) {
          $.ajax({
              url: '{!! route('maintenance.application.systemDown') !!}',
              type: 'POST',
              async: false,
              success: function(response) {
                 
              }
          });
      }

</script>

@endpush