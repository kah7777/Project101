<form action="/post/{{ $post->id }}" method="POST">
    @method('PATCH')
    @csrf
    <input type="text" id="title" name="title" value="{{ $post->title }}">
    <input type="text" id="text" name="text" value="{{ $post->text }}">
    <button>submit</button>
</form>
