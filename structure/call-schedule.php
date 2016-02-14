<!-- Modal -->
<div class="modal fade call-schedule-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="sc-modal-label">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sc-modal-label">Schedule a call</h4>
      </div>
      
      <div class="modal-body">
	       <form id="call-schedule-form">
                 <div class="form-group">
                      <label class="control-label" for="sc-name">Full Name:</label>
                      <input type="text" class="form-control" id="sc-name" dname="Name">
                 </div>
                  <div class="form-group">
                      <label class="control-label" for="sc-phone">Phone Number:</label>
                      <input type="text" class="form-control number-only" id="sc-phone" dname="Phone Number">     
                  </div>
                   <div class="form-group">
                        <label>Query Regarding:</label>
                        <select class="form-control" id="sc-query">
                        	<option selected='selected'>IELTS</option>
                           	<option>International University</option>
                           	<option>Country Specific</option>
                           	<option>Existing Application</option>
                        </select>
                   </div>
			</form>
      </div>
      
      <div class="modal-footer">
        <button class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="schedule-button" data-loading-text="Scheduling...">Schedule</button>
		<p id='sc-status'></p>
      </div>
      
    </div>
  </div>
</div>