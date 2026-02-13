<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('styles')
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="icon">🔧</span>
            <h2>Admin Panel</h2>
        </div>

        <ul class="sidebar-menu">
            <li class="active">
                <span class="icon">📊</span>
                <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
            </li>
            <li>
                <span class="icon">📝</span>
                <a href="{{ route('admin.posts.index') }}">All Posts</a>
            </li>
            <li>
                <span class="icon">⏳</span>
                <a href="#">Pending Review</a>
            </li>
            <li>
                <span class="icon">👥</span>
                <a href="{{route('admin.users.index')}}">Users</a>
            </li>
            <li>
                <span class="icon">🏠</span>
                <a href="{{ route('home') }}">View Site</a>
            </li>
            <li>
                <span class="icon">⚙️</span>
                <a href="{{ route('profile.edit') }}">Settings</a>
            </li>
            <li>
                <span class="icon">🚪</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>

    <main class="main-content">
        @yield('content')
    </main>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
