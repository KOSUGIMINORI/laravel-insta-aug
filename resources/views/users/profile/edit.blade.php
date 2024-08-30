@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update') }}" enctype="multipart/form-data" method="post" class="bg-white rounded-3 p-5 shadow">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">
                    UPDATE PROFILE
                </h2>
                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt=""
                                class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="" class="form-control form-control-sm mt-1">
                        <div class="form-text">
                            Acceptable formats: jpeg, jpg, gif only <br>
                            Max file size is 1048kb
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>


             

                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="3" class="form-control" placeholder="Write an introduction..">{{ $user->introduction }}</textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-warning px-5">Save Profile</button>
            </form>
        </div>
    </div>
@endsection
