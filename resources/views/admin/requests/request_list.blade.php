@extends('layout.index')

@section('content')
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Request List</h3>
            <div class="flex-stuff">
                <div class="flex-stuff">
                    <input type="checkbox" class="remove-margin">
                    <div class="margin-left-5">Filter</div>
                </div>
                <div class="flex-stuff margin-auto flex-stuff-end">
                    <div>Trip Ticket Legend:</div>
                    <button class="btn btn-info btn-sm">New Ticket</button>
                    <button class="btn btn-warning btn-sm">Ticket Printed</button>
                    <button class="btn btn-success btn-sm">Completed</button>
                    <button class="btn btn-danger btn-sm">Cancelled</button>
                </div>
                <div class="flex-stuff margin-right-auto">
                    <button id="add-new-vehicle-request-list" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add New</button>
                    <a href="{{ route('vehicle.request.export') }}" target="__blank" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download List</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-responsive">
                    <table id="dataTableRequests" style="font-size:11px;" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Request No.</th>
                            <th>Dept.</th>
                            <th>Date Needed</th>
                            <th>Date Requested</th>
                            <th>Purpose</th>
                            <th>Last Message</th>
                            <th>Status</th>
                            <th>Trip Ticket</th>                  
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.requests.add_request_modal')
            @include('admin.requests.edit_request_modal')
            @include('admin.requests.add_message')
        </div>
    </div>
</div>

@endsection('content')

@section('javascript')

@endsection