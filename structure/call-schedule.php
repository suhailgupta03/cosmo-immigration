<!-- Modal -->
<div class="modal fade call-schedule-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="sc-modal-label">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sc-modal-label">Schedule a call</h4>
      </div>
      
      <div class="modal-body">
	       <form id="call-schedule-form" novalidate>
                 <div class="control-group form-group">
                     <div class="controls">
                          <label>Full Name:</label>
                          <input type="text" class="form-control" id="sc-name" required data-validation-required-message="Please enter your name.">
                          <p class="help-block"></p>
                      </div>
                 </div>
                  <div class="control-group form-group">
                        <div class="controls">
                            <label>Phone Number:</label>
                            <input type="text" class="form-control" id="sc-phone" required data-validation-number-message="Please enter your phone number.">
                        </div>
                   </div>
                   <div class="form-group">
                        <label>Query Regarding:</label>
                        <select class="form-control">
                        	<option selected='selected'>IELTS</option>
                           	<option>International University</option>
                           	<option>Country Specific</option>
                           	<option>Existing Application</option>
                        </select>
                   </div>
                   <div id="success"></div>
			</form>
      </div>
      
      <div class="modal-footer">
        <button class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="schedule-button" data-loading-text="Scheduling...">Schedule</button>
      </div>
      
    </div>
  </div>
</div>