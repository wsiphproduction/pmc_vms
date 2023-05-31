@extends('layout.home')

@section('content')
<div class="content" style="width:56%;">
	<h1 style="color:white;text-align:center;">Downtime Monitoring</h1>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="tiles">
				<div class="tile bg-red selected" onclick="window.location.href='{{ route('form.dashboard')}}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-tachometer"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Dashboard
						</div>
					</div>
				</div>

				<div class="tile bg-blue selected" onclick="window.location.href='{{ route('downtime.downtimes') }}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-file-text-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Downtime List
						</div>
					</div>
				</div>

				<div class="tile bg-yellow-lemon selected" onclick='window.open("{{ route('downtime.create') }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=700");'>
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-pencil-square-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Add New
						</div>
					</div>
				</div>
				
				<div class="tile bg-purple selected" onclick="window.location.href='{{ route('form.maintenance')}}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-cogs"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							System Maintenance
						</div>
					</div>
				</div>				

				<div class="tile bg-green selected" onclick='window.open("{{ route('maintenance.export', 'raw_data') }}","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=500");'>
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Reports
						</div>
					</div>
				</div>

				<div class="tile bg-red-pink selected" onclick="window.location.href='{{route('utilization.dashboard')}}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-cog"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Utilization
						</div>
					</div>
				</div>

				<div class="tile selected" onclick='window.open("http://mlappsvr.philsaga.com/PMC-VMS/public/storage/VMS%20Manual.pdf","displayWindow","toolbar=no,scrollbars=yes,width=1200,height=500");'>
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-book"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							User Manual
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<br>
<div class="content" style="width:56%;">
	<h1 style="color:white;text-align:center;">Utilization Monitoring</h1>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="tiles">
				<div class="tile bg-red selected" onclick="window.location.href='{{ route('utilization.dashboard')}}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Dashboard
						</div>
					</div>
				</div>

				<div class="tile bg-blue selected" onclick="window.location.href='{{ route('vehicle.request.list', ['page' => 1]) }}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-bars"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Request List
						</div>
					</div>
				</div>

				<div class="tile bg-purple selected" onclick="window.location.href='{{ route('vehicle.request.list', 'addNew') }}'">
					<div class="corner"> </div>
					<div class="tile-body">
						<i class="fa fa-file-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Add New
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="vehicle-request-create-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="mr-auto">Success!</strong>
    <button id="close-toast-vehicle-request" type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Vehicle Request Created!
  </div>
</div>


@endsection
