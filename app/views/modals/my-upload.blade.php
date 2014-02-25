

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="error-modal-label">Error</h4>
      </div>
   		<div class="modal-body">
	    	
	    </div>
	    <div class="modal-footer">
	        <button class="btn btn-danger" data-dismiss="modal">OK</button>
	    </div>
    </div>
  </div>
</div>




<div class="modal fade" id="delete-item-modal" tabindex="-1" role="dialog" aria-labelledby="delete-item-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="delete-item-modal-label">Confirm delete</h4>
      </div>
   		<div class="modal-body">
	    	<p>
	    		Are you sure you want to delete this? <span class="text-danger">This action is irreversible!</span>
	    	</p>
	    </div>
	    <div class="modal-footer">
	        <a href="javascript:;" id="delete-confirm" class="btn btn-danger">Yes</a>
	        <a href="javscript:;" data-dismiss="modal" class="btn btn-primary">No</a>
	    </div>
    </div>
  </div>
</div>



<div class="modal fade" id="collection-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Photos to Collection</h4>
      </div>
		@if(count($collections) > 0)
	     {{Form::open(array('route' => 'my-collections/add-photos', 'style' => 'margin: 0px;'))}}
	    <div class="modal-body">
	    	<span class="message">Add selected photos to your collection:</span>
	     	<input id="photoarray" type="hidden" name="photoarray" value=""/>
	     	<div class="form-group">
		     	<select name="collection_id" class="form-control">
				@foreach($collections AS $collection)
					<option value="{{$collection->id}}">{{$collection->title}}</option>
				@endforeach
		     	</select>
	     	</div>
	    </div>
	    <div class="modal-footer">
	        <input type="submit" value="Add Photos" class="btn btn-success"/>
	        <a href="javscript:;" data-dismiss="modal" class="btn btn-danger">Cancel</a>
	    </div>
	    {{Form::close()}}
	    @else
		    <div class="modal-body">
		     	You don't have any collections yet. <a href="/my-collections/create">Create one now.</a>
		    </div>
		    <div class="modal-footer">
		        <a href="javscript:;" data-dismiss="modal" class="btn btn-primary">OK</a>
		    </div>
	    @endif
    </div>
  </div>
</div>
