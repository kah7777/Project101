<form action="/post/{{ $post->id }}" method="POST">
    @method('PATCH')
    @csrf
    <br>
    <br>
    <input type="text" id="title" name="title" value="{{ $post->title }}">
    <br>
    <br>
    <textarea type="text" name="text" id="text">{{ $post->text }}</textarea>
    <br>
    <br>
    <button>submit</button>
</form>
