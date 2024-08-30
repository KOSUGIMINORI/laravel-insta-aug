@extends('layouts.app')


@section('title', 'Admin:users')


@section('content')

        <table class="table -hover align-middle">
            <thead class="table-sm table-success">
                <tr>
                    <td class="col"></td>
                    <td class="col">NAME</td>
                    <td class="col">EMAIL</td>
                    <td class="col">CREATED AT</td>
                    <td class="col">STATUS</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($all_users as $user)
                    <tr>
                        <td>
                            @if ($user->avatar)
                                <img src="{{$user->avatar}}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                            @else
                                <i class="fa-solid fa-circle-user text-dark icon-md text-center d-block"></i>
                            @endif
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td class="text-center">
                            @if ($user->trashed())
                                <i class="fa-solid fa-circle text-danger"></i>
                            @else
                                <i class="fa-solid fa-circle text-success"></i>
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->id != $user->id)
                                <button type="button" class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    @if ($user->trashed())
                                        <button type="button" class="btn dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{$user->id}}">
                                            <i class="fa-solid fa-user-check"></i> Activate {{$user->name}}
                                        </button>
                                    @else
                                        <button type="button" class="btn dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                                            <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                        </button>
                                    @endif
                                </div>
                            @endif
                            @include('admin.users.modal.status')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
  

@endsection