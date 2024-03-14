<h1>All Our Posts</h1>
<a href="/post/create">add your post here</a>
<ul>
    @foreach ($posts as $post)
        <a href="/post/{{ $post->id }}">
            <li style="list-style:none">
                    <h2>{{ $post->title }}<br><br>
                </a>
            </li>
    @endforeach
</ul>

