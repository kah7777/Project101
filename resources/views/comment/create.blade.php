<form action="{{ route('post.comment.store'),$post->id }}" method="POST">
    @csrf
<input type="text" name="comment" id="comment">
<button type="submit">Submit</button>
</form>
<br>
<br>
