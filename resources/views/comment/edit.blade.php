<h3>Edit your comment below :</h3>
<form action="comment/{{ $comment->id }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="text" id="text" name="text">
</form>
