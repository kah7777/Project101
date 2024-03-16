<h1>{{ $post->title }}</h1>
<p style="width: 300px">{{ $post->text }}</p>
<br>
<a href="/post/{{ $post->id }}/edit">edit</a>
<br>
<br>
<br>
<form action="/post/{{ $post->id }}" method="post">
@csrf
@method('DELETE')
<button>Delete</button>
</form>
<br>
<br>
<h4>Write Your Comment Here :</h4>

<form action="./{{ $post->id }}/comment" method="POST">
    @csrf
<input type="text" name="text" id="text">
<input name="post_id" type="hidden" value="{{ $post->id }}">
<p>{{ $errors->first('text') }}</p>
<button type="submit">Submit</button>
</form>
<br>
<br>

Comments
<br>
<br>
@foreach ($post->comments as $comment)
    <div>{{ $comment->text }}</div> <br>

@endforeach





