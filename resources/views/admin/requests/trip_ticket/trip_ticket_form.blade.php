@extends('layout.index')

@section('content')
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">TRIP DETAILS</h3>
            <div class="col-12 flex-stuff request-list-nav">
                <a href="/">
                    <i class="fa fa-home"></i>
                    HOME
                    <span class="margin-left">/</span>
                </a>
                <a href="{{ route('vehicle.request.list') }}" style="margin-left: 10px">
                    <i class="fa fa-list"></i>
                    REQUEST LIST
                    <span class="margin-left">/</span>
                </a>
                <a href="#" style="margin-left: 10px">
                    <i class="fa fa-tag"></i>
                    TICKET CREATION
                    <span class="margin-left">/</span>
                </a>
            </div>
            <div class="portlet-body margin-top-20">
                <div class="border padding-small">
                    <div class="flex-stuff" style="color: #7FBF3F;">
                        <i class="fa fa-truck" style="color: #7FBF3F; margin-right: 5px;"></i>
                        VEHICLE DISPATCH FORM REQUEST # : {{ $id }}
                    </div>
                    <hr>
                    <form class="uk-grid-small uk-margin-top" action="{{ route('vehicle.dispatch.create', ['dept_id' => $request->department->id, 'id' => $request->id]) }}" method="POST" class="form-grid" id="vehicle-request-form" uk-grid>
                        @csrf
                        <div class="uk-width-1-1 uk-margin-small-left padding-small container-section">
                            <h5>TRIP TICKET FORM</h5>
                            <div style="color: #A6270A;"></div>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-out"><strong>Date Out *</strong></label>
                            <input class="uk-input uk-form-small" name="do" id="dateEnd" type="date" date-format="Y-m-d" required>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-out"><strong>Department *</strong></label>
                            <input class="uk-input uk-form-small" value="{{ $request->department->name }}" type="text" name="department" id="department" placeholder="Department" readonly>
                        </div>
                        <div class="uk-width-1-3@s uk-width-1-1">
                            <label for="date-out"><strong>Vehicles *</strong></label>
                            <select name="unit_id" id="unit_id" class="uk-select uk-form-small" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1" >
                            <label for="date-out"><strong>Date Needed *</strong></label>
                            <input class="uk-input uk-form-small" value="{{ $request->date_needed }}" type="date" name="app_date" placeholder="25" readonly>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-out"><strong>Driver *</strong></label>
                            <!-- <input class="uk-input uk-form-small" type="text" name="driver" placeholder="Driver Name"> -->
                            <select name="vehicle" id="driver_id" class="uk-select uk-form-small" required>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-out"><strong>To *</strong></label>
                            <input class="uk-input uk-form-small" value="{{ $request->department->name }}" type="text" name="do" placeholder="50" readonly>
                        </div>
                        {{-- <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-out"><strong>From *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="destination" placeholder="Destination" required>
                        </div> --}}
                        <div class="uk-width-1-1">
                            <label for="date-out"><strong>Purpose *</strong></label>
                            <textarea class="uk-textarea" name="purpose" disabled>{{ $request->purpose }}</textarea>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>Odometer Start *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="odometer_start" placeholder="Odometer Start" required>
                        </div>
                        <div class="uk-width-1-2@s uk-width-1-1">
                            <label for="date-"><strong>Passengers *</strong></label>
                            <div class="uk-flex">
                                <input class="uk-input uk-form-small" type="text" name="passengers[]" placeholder="Passenger" required>
                                <button id="add-passenger" class="btn btn-info btn-sm">Add</button>
                            </div>
                        </div>

                        <div class="uk-width-1-1 uk-margin-small-left padding-small container-section uk-m">
                            <h5>FUEL SLIP FORM</h5>
                            <div style="color: #A6270A;"></div>
                        </div>

                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>Cost Code *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="vehicle_cost_code" value="{{ $request->costcode }}" placeholder="Cost Code" readonly required>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>RQ Number *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="RQ" placeholder="RQ Number" required>
                        </div>
                        <div class="uk-width-1-2@s"></div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>Fuel Type *</strong></label>
                            <select name="fuel_added_type" id="vehicle" class="uk-select uk-form-small" required>
                                @foreach($fuel_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>Item Code *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="itemCode" placeholder="Item Code" required>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>Requested Fuel Qty *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="fuel_requested_qty" placeholder="Quantity" required>
                        </div>
                        <div class="uk-width-1-4@s uk-width-1-1">
                            <label for="date-"><strong>UOM *</strong></label>
                            <input class="uk-input uk-form-small" type="text" name="uom" placeholder="Liter" required>
                        </div>
                        <div class="uk-width-1-1 uk-flex uk-flex-right">
                            <button class="btn btn-info btn-sm">Submit</button>
                            <a href="{{ route('vehicle.request.list') }}" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i> Cancel</a>
                            <a href="{{ route('vehicle.request.list') }}" class="btn btn-warning btn-sm"><i class="fa fa-times-circle"></i>Close</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>  
@endsection('content')