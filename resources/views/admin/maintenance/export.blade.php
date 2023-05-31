<!DOCTYPE html>
<html lang="en">
<head>
    <script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/excel/src/jquery.table2excel.js') }}"></script>
</head>
<body>
    <table id="excel" style="font-family:Arial;font-size:12px;">
        {{-- Assigned --}}
        @if(isset($assigned))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($assigned as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td>
            </tr>
            @endforeach
        </tbody>

        {{-- Unit --}}
        @elseif(isset($unit))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Type</td>
                <td>Required Availability Hours</td>
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($unit as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->type}}</td>
                <td>{{number_format($item->required_availability_hours, 2)}}</td>
            </tr>
            @endforeach
        </tbody>

        {{-- Mechanic --}}
        @elseif(isset($mechanic))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>		
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($mechanic as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td> 
            </tr>
            @endforeach
        </tbody>

        {{-- Status --}}
        @elseif(isset($unitstatus))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>		
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($unitstatus as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td> 
            </tr>
            @endforeach
        </tbody>


        {{-- Preventive --}}
        @elseif(isset($preventive))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>		
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($preventive as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td> 
            </tr>
            @endforeach
        </tbody>

        {{-- Breakdown --}}
        @elseif(isset($preventive))
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>		
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($preventive as $item)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$item->name}}</td> 
            </tr>
            @endforeach
        </tbody>

        {{-- Downtime Report --}}
        @elseif(isset($raw_data))
        <thead>
            <tr>
                <th>ID</th>
                <th>Unit</th>
                <th>Category</th>
                <th>Status</th>
                <th>Reported</th> 
                <th>Start</th>
                <th>End</th>   
                <th>Assigned To</th>                                    
                <th>Remarks</th>
                <th>Type</th>
                <th>Work Order</th>
                <th>Repair Type</th>
                <th>Work Details</th>
                <th>Mechanics</th>
                <th>From 12 AM</th>
                <th>From 7 AM</th>
                <th>Repair Days</th>
                <th>Repair Hours</th>
                <th>Shop Days</th>
                <th>Shop Hours</th>
                <th>Man Hours</th>
                <th>Required Daily Availability</th>
                <th>Downtime</th>
                <th>Added By</th>
                <th>Added Date</th>     
            </tr>
        </thead>
        <tbody>
            <div style="visibility: hidden">{{$count = 0}}</div>
            @foreach ($raw_data as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->uni}}</td>
                <td>{{$item->type}}</td>
                <td>{{$item->status}}</td>
                <td>{{$item->reportedDate}}</td>
                <td>{{$item->dateStart}}</td>
                <td>{{$item->dateEnd}}</td>
                <td>{{$item->assignedTo}}</td>
                <td>{{$item->remarks}}</td>

                @if($item->isScheduled == 1)

                <td>Corrective/PM</td>

                {{-- @elseif($item->isScheduled == 1) // There are 2 same conditional statement 

                <td>Breakdown</td> --}}

                @endif

                <td>{{$item->workOrder}}</td>
                <td>{{$item->repairType}}</td>
                <td>{{$item->workDetails}}</td>
                <td>{!! str_replace('|',',', $item->mechanics) !!}</td>
                <td>{{$item->from12}}</td>                                                  
                <td>{{$item->from7}}</td>
                <td>{{$item->trepair_days}}</td>
                <td>{{$item->trepair_hours}}</td>
                <td>{{$item->shop_days}}</td>
                <td>{{$item->shop_hours}}</td>
                <td>{{$item->man_hours}}</td>
                <td>{{$item->required_daily_availability}}</td>
                <td>{{$item->tdowntime}}</td>
                <td>{{$item->addedBy}}</td>
                <td>{!! date('Y-m-d H:i:s', strtotime($item->addedDate)) !!}</td>
            </tr>
            @endforeach
        </tbody>

        @endif

    </table>
</body>

<script>
	jQuery(document).ready(function() {

		exportToExcel('#excel');

	});

	function exportToExcel(table) {
		jQuery(table).table2excel({
			name: "VMS",
			filename: "VMS" //do not include extension
		});
	}
</script>
</html>
