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