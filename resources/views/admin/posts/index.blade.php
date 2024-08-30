@extends('layouts.app')

@section('title', 'Admin:index')

@section('content')
    <table class="table -hover align-middle">
        <thead class="table-sm table-primary">
            <tr>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col">CATEGORY</td>
                <td class="col">OWNER</td>
                <td class="col">CREATED AT</td>
                <td class="col">STATUS</td>
                <td class="col"></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td>
                        {{$post->id}}
                    </td>
                    <td>
                        <a href="{{route('post.show',$post->id)}}">
                        <img src="{{ $post->image }}" alt="" class="img-thumbnail avatar-lg">
                        </a>
                        {{--@if ($post->user->avatar)
                            <img src="{{$post->user->avatar}}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                        @else
                            <i class="fa-solid fa-circle-user text-dark icon-md text-center d-block"></i>
                        @endif--}}
                    </td>
                    <td>
                        @foreach ($post->category_post as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">
                                {{ $category_post->category->name }}
                            </div>
                        @endforeach
                        {{--{{$post->category}}--}}
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                            {{ $post->user->name }}
                        </a>
                        {{--{{$post->user->name}}--}}
                    </td>
                    <td>
                        {{ $post->created_at->diffForHumans() }}
                    </td>
                    <td class="text-center"> 
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle text-secondary"></i>
                        @else
                            <i class="fa-solid fa-circle text-primary"></i>
                        @endif
                    </td>

                    <td>
                        <button type="button" class="btn btn-sm"datta-bs-toggle=dropdown>
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    <button type="button" class="btn dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#visible-post-{{$post->id}}">
                                        <i class="fa-solid fa-user-check"></i> Activate post ID: {{$post->id}}
                                        </button>
                                @else
                                    <button type="button" class="btn dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#unvisible-post-{{ $post->id }}">
                                        <i class="fa-solid fa-user-slash"></i> Deactivate post ID: {{ $post->id }}
                                    </button>
                                @endif
                            </div>
                        @include('admin.posts.modal.status')
                    </td>
                </tr>
            
            @endforeach
        </tbody>
    </table>

@endsection