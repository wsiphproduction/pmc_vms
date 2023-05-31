<div id="add-request-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Vehicle Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('vehicle.request.create') }}" method="POST" class="form-grid" id="vehicle-request-form">
            @csrf
            <div class="form-group-row">
                <label for="department" class="col-sm-4 col-form-label black">Dept.</label>
                <div class="col-sm-4">
                    <select name="dept" id="departments-select" class="form-control">
                        <option value="" disabled>Select Dept</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <div id="dept-error" class="error"></div>
                </div>
                <div class="col-sm-4">
                    <input type="text" name="new_dept" id="new_dept" class="form-control" placeholder="Or input new dept">
                </div>
            </div>
            <div class="form-group-row margin-top-20">
                <label for="date-needed" class="col-sm-4 col-form-label black">Date Needed</label>
                <div class="col-sm-4">
                    <input type="date" name="date_needed" id="date_needed" class="form-control" placeholder="Specify date">
                    <div id="date-needed-error" class="error"></div>
                </div>
            </div><div class="form-group-row margin-top-20">
                <label for="date-needed" class="col-sm-4 col-form-label black">Chargeable Cost Code:</label>
                <div class="col-sm-4">
                    <input type="text" name="costCode" id="costCode" class="form-control" placeholder="Enter cost code">
                    <div id="costCode-error" class="error"></div>
                </div>
            </div>
            <div class="form-group-row margin-top-20">
                <label for="date-needed" class="col-sm-4 col-form-label black">Purpose</label>
                <div class="col-sm-8">
                    <textarea name="purpose" id="purpose" class="form-control" placeholder="Enter purpose here" rows="5"></textarea>
                    <div id="purpose-error" class="error"></div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button id="submit-vehicle-request" class="btn btn-primary" >Save</button>
            </div>
        </form>
        
      </div>
     
    </div>
  </div>
</div>
