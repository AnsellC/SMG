@extends('layout.default')
@section('content')

<div class="row main-content">

	@if($photo->private == 1)
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="alert alert-danger text-center">
				This photo is set to <strong>private</strong>. Currently you are the only one who can access this until you set it to <strong>public</strong>
			</div>
		</div>
	</div>
	@endif
	<div class="col-md-7 col-md-offset-1 photo-holder">
		<div class="hold">
			<img src="{{{ Storage::getPhoto($photo->file_path) }}}" alt="{{{ $photo->file_name }}}" class="img-responsive" />
		</div>
		@if(!empty($photo->description))
			<div class="photo-description">
						{{{ $photo->description }}}
			</div>
		@endif
	</div>
	<div class="col-md-3 photo-sidebar">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-left title">
					<h3 class="panel-title">{{{ $photo->file_name }}}</h3>
				</div>
				<div class="pull-right likes">
					<span data-toggle="tooltip" title="Likes"><i class="fa fa-thumbs-up"></i> {{ number_format(count($photo->likers))}}</span>
					<span data-toggle="tooltip" title="Views"><i class="fa fa-eye"></i> {{ number_format($photo->views)}}</span>
					<span data-toggle="tooltip" title="Collections having this photo"><a href="/{{ $photo->file_path }}/collections"><i class="fa fa-folder-open"></i> {{ count($photo->collections) }}</a></span>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				 <div class="photo-author sidebar-item">
					<div class="avatar">
						<a href="/users/{{{ $photo->user->username }}}"><img src="{{{ $photo->user->getProfilePic('60x60') }}}" class="img-rounded" alt="" /></a>
					</div>
					<div class="name">
						<div class="author">
							<a href="/users/{{{ $photo->user->username }}}">{{ $photo->user->username }}</a>
						</div>
						<div class="buttons">
							<a class="btn btn-xs btn-blue" href="/follow/{{ $photo->user->username }}"><i class="fa fa-hand-o-right"></i> Follow</a>
						</div>
					</div>
					<div class="clearfix"></div>
				 </div>
				 
				 <div class="photo-buttons row">
				 	@if($photo->allow_collect == "1" OR $photo->isMine())
						<div class="col-lg-6 col-xs-6 text-center">
							@if($photo->iLike())
								<button id="unlike-btn" data-photo-id="{{$photo->id}}" class="btn btn-danger btn-block"><i class="fa fa-thumbs-down"></i> Unlike</button>
							@else
								<button id="like-btn" data-photo-id="{{$photo->id}}" class="btn btn-success btn-block"><i class="fa fa-thumbs-up"></i> Like</button>
							@endif
						</div>
						<div class="col-lg-6 col-xs-6 text-center">
							<button data-target="#collection-modal" class="btn btn-warning btn-block" data-toggle="modal"><i class="glyphicon glyphicon-folder-open"></i> Add to Collection</button>
						</div>
					@else

						<div class="col-lg-12 text-center">
							@if($photo->iLike())
								<button id="unlike-btn" data-photo-id="{{$photo->id}}" class="btn btn-danger btn-block"><i class="fa fa-thumbs-down"></i> Unlike</button>
							@else
								<button id="like-btn" data-photo-id="{{$photo->id}}" class="btn btn-success btn-block"><i class="fa fa-thumbs-up"></i> Like</button>
							@endif
						</div>
					@endif
				 </div>
<!--				 @if(count($photo->collections) > 0)
				 	<a class="collection" href="#">This photo appears on {{number_format(count($photo->collections))}} collections <i class="glyphicon glyphicon-chevron-right"></i></a>
				 @endif -->
				 <div class="comments row">
					@if(count($photo->comments) == 0)

						<div class="no-comments">No comments yet. Be the first one by writing a comment below.</div>

					@else
									@foreach($photo->comments()->with('user')->orderBy('created_at')->get() AS $comment)

									<div class="media">
									  <a class="pull-left" href="/users/{{{ $comment->user->username }}}">
									    <img class="media-object" src="{{{ $comment->user->getProfilePic('40x40') }}}" alt="" />
									  </a>
									  <div class="media-body">
									    <a class="username" href="/users/{{{ $comment->user->username }}}">{{{ $comment->user->username }}}</a><br />
									    {{ strip_tags(nl2br($comment->content), '<br/>,<br>') }}
									    <span class="time">{{{ Date::make($comment->created_at)->ago() }}}</span>
									  </div>
									</div>
									@endforeach
					@endif
								
				 </div>
			</div>
			<div class="panel-footer comment-footer">
				
				
					
					<div class="comment-box">
						@if(!Auth::guest())
							{{ Form::open(array('route' => 'photocomments/create', 'role' => 'form', 'method' => 'POST')) }}
							<input type="hidden" value="{{$photo->id}}" name="photo_id"/>
							<textarea name="content" class="form-control comment-txt" placeholder="Write something about this photo..." /></textarea>
							{{ Form::close() }}
						@else
							<textarea name="content" class="disabled form-control comment-txt" placeholder="Please login to post a comment..." disabled="disabled" /></textarea>
						@endif
					</div>
					
						<div class="btn-group cog dropup">
					    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					    <i class="fa fa-ellipsis-h fa-2x"></i> 
					    </button>
					    <ul class="dropdown-menu pull-right text-right">
					      <li><a href="#">Report this photo</a></li>
					      @if($photo->isMine())
					      	<li><a href="/photos/edit/{{$photo->id}}">Edit Photo</a></li>
					      @endif
					    </ul>
					  </div>
					

					<div class="clearfix"></div>				
				
				

			</div>
		</div>
	</div>

</div>

@stop
