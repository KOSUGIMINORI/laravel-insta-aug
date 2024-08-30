@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <style>
        .col-4{
            overflow-y: scroll;
        }
        .card-body{
            position: absolute;
            top: 65px;
        }
    </style>

    <div class="row border shadow">
        <div class="col p-0 border-end">
            {{-- IMAGE --}}
            <img src="{{ $post->image }}" alt="Post ID {{ $post->id }}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            {{-- POST INFO --}}
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="">
                                @if($post->user->avatar)
                                    <img src="" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0">
                            <a href="" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
                        </div>

                        <div class="col-auto">
                            {{-- IF you are the OWNER of the post, you can EDIT or DELETE the post. --}}
                            @if(Auth::user()->id === $post->user->id)
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                </div>

                                <div class="dropdown-menu">
                                    <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                        <i class="fa-regular fa-edit"></i> Edit
                                    </a>
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                        <i class="fa-regular fa-trash-can"></i> Delete
                                    </button>
                                </div>
                                @include('users.post.contents.modals.delete')
                            @else
                            {{-- IF you are NOT the OWNER of the POST, show the FOLLOW/UNFOLLOW button [DISCUSSED LATER] --}}
                                <form action="" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body w-100">
                    {{-- HEART BUTTON + no. of likes + categories --}}
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <form action="" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm shadow-none p-0">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>
                        </div>

                        <div class="col-auto px-0">
                            <span>3</span>
                        </div>

                        <div class="col text-end">
                            @foreach($post->category_post as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Owner + Description --}}
                    <a href="" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{$post->description}}</p>
                    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
                    {{-- date(format, unix time) ~~ formats the date. --}}
                    {{-- strtotime(timestamp) ~~ converts the string to a timestamp --}}

                    {{-- Include Comments Here --}}
                    @if($post->comments->isNotEmpty())
                        <ul class="list-group mt-2">
                            @foreach($post->comments as $comment)
                                <li class="list-group-item border-0 p-0 mb-2">
                                    <a href="" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                                    &nbsp;
                                    <p class="d-inline fw-light">{{ $comment->body }}</p>

                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <span class="text-uppercase text-muted xsmall">
                                            {{ date('M d, Y', strtotime($comment->created_at)) }}
                                        </span>

                                        {{-- IF the ayth user is the OWNER of the comment, show a delete button --}}
                                        @if(Auth::user()->id === $comment->user->id)
                                            &middot;
                                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                        @endif
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection