<!-- Modal -->
<div class="modal fade currency-converter-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-label">Currency Converter</h4>
      </div>
      
      <div class="modal-body">
       <form class="form-horizontal">       
		  <div class="form-group">
		    <label for="currency-converter-amount" class="col-sm-3 control-label">Amount</label>
		    <div class="col-sm-9">
		      <input type="text" class="form-control" id="currency-converter-amount" Value="1">
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label for="currency-converter-from" class="col-sm-2 control-label">From</label>
		    <div class="col-sm-10">
		      <select class="form-control currency-converter-sb" id="currency-converter-from"></select>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label for="currency-converter-to" class="col-sm-2 control-label">To</label>
		    <div class="col-sm-10">
		      <select class="form-control currency-converter-sb" id="currency-converter-to"></select>
		    </div>
		  </div>
		</form>
		<div class="currency-converter-result text-center"></div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="currency-converter-button" data-loading-text="Converting...">Convert</button>
      </div>
      
    </div>
  </div>
</div>