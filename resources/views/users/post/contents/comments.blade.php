<div class="mt-3">
        {{-- show all comments here.. --}}
    @if($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $comment->body }}</p>
                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <span class="txst-uppercase text-muted xsmall">
                            {{ date('M d, Y', strtotime($comment->created_at)) }}
                        </span>

                        {{-- IF the AUTH user is the OWNER of the COMMENT, show a DELETE button --}}
                        @if(Auth::user()->id === $comment->user->id)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                        @endif
                    </form>
                </li>
            @endforeach

            @if($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">
                        View all {{ $post->comments->count() }} comments
                    </a>
                </li>
            @endif
        </ul>
    @endif

        {{-- Owner + Description --}}
    {{--<a href="" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
    &nbsp;
        <p class="d-inline fw-light">{{$post->description}}</p>
        <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
        {{-- date(format, unix time) ~~ formats the date. --}}
        {{-- strtotime(timestamp) ~~ converts the string to a timestamp --}}

    <form action="{{ route('comment.store',$post->id) }}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="body" id="body" rows="1" class="form-control form-control-sm" placeholder="Add a comment.."></textarea>
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fa-regular fa-paper-plane"></i>
            </button>

        </div>
    </form>
</div>


{{--@if(Auth::user()->id === $post->user->id)
            <div class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-comment-{{ $comment->id }}">
                <a href="">delete</a>
            </div>--}}