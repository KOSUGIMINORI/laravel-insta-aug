@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
                <div class="mb-3">
                    <label for="categories" class="form-label fw-bold d-block">
                        Categories <span class="text-muted fw-normal">(Up to 3)</span>
                    </label>

                    @foreach ($all_categories as $category)
                        <div class="form-check form-check-inline">
                            {{-- in_array() ~~ it will check if the category ID is IN THE ARRAY of $selected_categories --}}
                            @if(in_array($category->id, $selected_categories))
                                <input type="checkbox" value="{{$category->id}}" name="category[]" id="{{$category->name}}" class="form-check-input" checked>                                
                            @else
                                <input type="checkbox" value="{{$category->id}}" name="category[]" id="{{$category->name}}" class="form-check-input">
                            @endif

                            <label for="{{$category->name}}" id="{{$category->name}}" class="form-check-label">
                                    {{$category->name}}
                            </label>
                        </div>
                    @endforeach

                    @error('category')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold text-capitalize">description</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $post->description) }}</textarea>
                    @error('description')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="image" class="form-label fw-bold text-capitalize">image</label>
                        <img src="{{ $post->image }}" alt="Post ID {{ $post->id }}" class="img-thumbnail w-100">

                        <input type="file" name="image" id="image" class="form-controlmt-1">
                        <div class="form-text">
                            The acceptable formats are jpeg, jpg, png, and gif only.<br>
                            Maximum file size: 1048kb
                        </div>
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>   
                </div>
                <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection