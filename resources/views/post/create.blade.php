<h1>Create your post here</h1>
<form action="\post" method="POST">
    @csrf
    <input type="text" name="title" id="title">
    <br>
    <input type="text" name="text" id="text">
    <br>
    <button>Submit</button>
</form>
