<h1>{{ $post->title }}</h1>
<p>{{ $post->text }}</p>
<a href="/post/{{ $post->id }}/edit">edit</a>
<br>
<br>
<form action="/post/{{ $post->id }}" method="post">
@csrf
@method('DELETE')
<button>Delete</button>
</form>









