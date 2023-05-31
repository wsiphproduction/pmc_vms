<div id="add-message-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" class="form-grid" id="vehicle-request-message">
            @csrf
            <label id="label-request-id" for="message" class="col-sm-4 col-form-label black"></label>
            <textarea name="message" id="request-message-form" cols="30" rows="5"></textarea>
            <div class="modal-footer">
              <button id="submit-vehicle-request" class="btn btn-primary">Send Message</button>
            </div>
        </form>
        
      </div>
     
    </div>
  </div>
</div>
