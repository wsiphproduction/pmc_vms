@extends('layout.vehicle_utilization.review')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('form.home') }}"><i class="fa fa-home"></i> HOME</a>
                            </li>
                            <li>
                                <a href="{{ route('vehicle.request.list') }}"><i class="fa fa-list"></i> REQUEST LIST</a>
                            </li>
                            <li class="active"><i class="fa fa-tags"></i> Summary</li>
                        </ol>

                    </div>
                </div>
            </div>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12 news-page blog-page">
                    <div class="row">
                        <div class="col-md-8 blog-tag-data">
                            <h3>Request Summary ({{ $vehicleRequest->refcode ?? 'Not Available' }})</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-inline blog-tags">
                                        <li>
                                            <i class="fa fa-tags"></i>
                                            <a href="#">{{ $vehicleRequest->name }}</a>
                                            <a href="#">{{ $vehicleRequest->dept }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6 blog-tag-data-inner">
                                    <ul class="list-inline">
                                        <li>
                                            <i class="fa fa-calendar"></i>
                                            <a href="#" title="Added by "> {{ $vehicleRequest->addedBy }} </a>
                                            {{ $vehicleRequest->added }}
                                        </li>
                                        <li><span style="visibility: hidden">{{ $counter = 0 }}</span>
                                            <i class="fa fa-comments"></i>
                                            <a href="#comment_table"> {{ $counter }} Comments </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h3>Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Costcode:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->costcode ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Date Needed:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->date_needed ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Status:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->status ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Purpose:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->purpose ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>

                                <h3>Pick-up Instructions</h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dept / Establishment:</label>
                                            <label
                                                class="control-label col-md-9">{{ $vehicleRequest->requestOtherInfo->pickup_dept ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Location / Site / Address:</label>
                                            <label
                                                class="control-label col-md-9">{{ $vehicleRequest->requestOtherInfo->pickup_location ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>

                                <h3>Delivery Instructions</h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Contact Person:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->requestOtherInfo->contact_person ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Designation:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->requestOtherInfo->designation ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Department:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->requestOtherInfo->dept }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Contact No:</label>
                                            <label
                                                class="control-label col-md-8">{{ $vehicleRequest->requestOtherInfo->contact_no ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Delivery Site:</label>
                                            <label
                                                class="control-label col-md-9">{{ $vehicleRequest->requestOtherInfo->delivery_site ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Other Delivery Instructions:</label>
                                            <label
                                                class="control-label col-md-9">{{ $vehicleRequest->requestOtherInfo->other_instructions ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>
                        <div class="col-md-4">
                            <h3>Vehicle Dispatched</h3>
                            <div class="top-news">
                                @if($dispatch) {{-- This will check if Ticket exists --}}
                                    @forelse($dispatch as $dpatch)
                                    <!-- <a href="#" class="btn {{$color}}"> -->
                                    <a href="#" class="btn @if($dpatch->Status=='Completed') green @elseif($dpatch->Status=='Cancelled') red @elseif($dpatch->Status=='Closed') red @elseif($dpatch->isPrinted==1) yellow @else blue @endif">
                                        <span>TN #:
                                            {{ $dpatch->tripTicket ?? 'Not available' }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehicle:
                                            {{ $dpatch->vehicle ?? 'Not available' }} 
                                        </span>
                                        <em>Schedule:
                                            {{ date('F d Y h:i A', strtotime($dpatch->dateStart ?? 'Not available')) }}</em>
                                        <em title="driver"><i class="fa fa-user"></i>
                                            {{ $dpatch->driver_name ?? 'Not available' }} 
                                        </em>
                                        <em><i class="fa fa-automobile"></i>
                                            {{ $dpatch->fuel_added_type ?? 'Not available' }} 
                                        </em>
                                        <em><i class="fa fa-fire"></i> Requested Qty :
                                            {{ $dpatch->fuel_requested_qty }}
                                            {{ $dpatch->uom }}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;
                                            Actual Qty : {{ $dpatch->fuel_added_qty }}
                                            {{ $dpatch->uom }}
                                        </em>
                                        <i class="fa fa-'.$type.' top-news-icon"></i>
                                    
                                    </a>
                                    @empty
                                        NO RECORD
                                    @endforelse
                                @endif
                            </div>
                            <div class="space20">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-comments font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Comments</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-condensed table-striped" id="comment_table">
                                        <thead>
                                            <tr>
                                                <th>Seq</th>
                                                <th>Sender</th>
                                                <th>Date</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($comments as $item)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $item->username }}</td>
                                                    <td>{{ date('F d Y h:i A', strtotime($item->added)) }}</td>
                                                    <td>{{ $item->comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-mail-reply-all font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Audit Trail</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Seq</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span style="visibility: hidden">{{ $cntr = 0 }}</span>
                                            @foreach ($logs as $item)
                                                <tr>
                                                    <td>{{ $cntr++ }}</td>
                                                    <td>{!! $item->action !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
@endsection
