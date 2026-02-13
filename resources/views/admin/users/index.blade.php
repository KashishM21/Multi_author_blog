@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection
@section('content')
    <div class="page-header">
        <h1 class="title">
            Users Management
            <span class="badge">{{ $users->count() }} users</span>
        </h1>
    </div>

    <div class="table-wrapper">
        <table class="table users-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Posts</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="user-name">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>{{ $user->posts_count }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="actions">
                            <a href="#" class="btn-action view">View Posts</a>
                            @if($user->id !== auth()->id())
                                <button class="btn-action edit" onclick="toggleRoleDropdown({{ $user->id }})">Change Role</button>
                                <div class="role-dropdown" id="role-dropdown-{{ $user->id }}" style="display: none;">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()">
                                            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </div>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="delete-form" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <
    </div>

    <script>
        function toggleRoleDropdown(userId) {
            var dropdown = document.getElementById('role-dropdown-' + userId);
            dropdown.style.display = dropdown.style.display === 'none' ? 'inline-block' : 'none';
        }
    </script>
@endsection
