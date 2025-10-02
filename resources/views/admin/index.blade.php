@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container" style="margin-top: 5rem;">
        <form method="GET" action="{{ route('admin.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="მოძებნე სახელი და გვარით, ან მეილით" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <h2>რეგისტრირებული მომხმარებლები</h2>
        <div class="table-responsive" style="padding-bottom: 10rem">
            <table class="table">
                <thead>
                <tr>
                    <th>სახელი</th>
                    <th>მეილი</th>
                    <th>როლი</th>
                    <th>მოქმედება</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="role" onchange="this.form.submit()" {{ $user->role === 'admin' ? 'disabled' : ''}}>
                                    <option value="waiting" {{ $user->role === 'waiting' ? 'selected' : '' }}>მოლოდინშია</option>
                                    <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>ოპერატორი</option>
                                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>ედიტორი</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ადმინი</option>
                                </select>
                            </form>



                            @if (Auth::user()->id === 1 || $user->role !== 'admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePassword{{ $user->id }}"><i class="fas fa-key"></i></button>
                            @endif

			    @if(Auth::user()->id === 1 || $user->role !== 'admin')
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="width: 40px"><i class="fas fa-trash" style="margin-right: 5px;"></i></button>
                            </form>
                                @endif
                        </td>


                        <div class="modal fade" id="updatePassword{{ $user->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">პაროლის შეცვლა: {{ $user->name }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.users.updatePassword', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="password" class="col-form-label">New Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="col-form-label">Confirm New Password:</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                        </div>
                                    </form>
                                </div>
                               
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
