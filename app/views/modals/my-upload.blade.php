<?php

## 
## MODAL SPECIFICALLY FOR MY-UPLOADS PAGE
##
?>
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
