

<div class="modal fade" style="z-index: 99999;" id="collection-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="error-modal-label">Add to Collection</h4>
      </div>
   		<div class="modal-body">
@if(Auth::user())
	    		@if(count(Auth::user()->collections) != 0)
	    		<p>Add this photo on this collection:</p>
	    			{{ Form::open(array('route' => 'my-collections/add-photos')) }}
	    			<input type="hidden" value="{{ $photo->id }}" name="photoarray">
	    			<select name="collection_id">
					@foreach(Auth::user()->collections AS $collection)
						<option value="{{ $collection->id }}">{{ $collection->title }}</option>
					@endforeach
					</select>
		</div>
	    <div class="modal-footer">
	       	<input type="submit" value="Add to collection" class="btn btn-success"/>

	        <a href="javscript:;" data-dismiss="modal" class="btn btn-danger">Cancel</a>
	    </div>	
	    			{{ Form::close() }}
				@else
					<p>
						You do not have any collections yet.
					</p>
		</div>
	    <div class="modal-footer">
	       
	        <a href="javscript:;" data-dismiss="modal" class="btn btn-primary">OK</a>
	    </div>	
				@endif
	    	@else
				<p>
					You must be logged in to add this to your collections.
				</p>
	    </div>
	    <div class="modal-footer">
	       
	        <a href="javscript:;" data-dismiss="modal" class="btn btn-primary">OK</a>
	    </div>				
			@endif
    </div>
  </div>
</div>
