<h1>Create your post here</h1>
<form action="\post" method="POST">
    @csrf
    <p>Please Write Your Tile</p>
    <input type="text" name="title" id="title">
    {{ $errors->first('title') }}
    <br>
    <br>
    <input type="text" name="text" id="text">
    {{ $errors->first('text') }}
    <br>
    <br>
    <button>Submit</button>
</form>
