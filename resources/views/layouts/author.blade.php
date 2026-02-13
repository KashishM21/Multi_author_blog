<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('styles')
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Author Panel
                <span class="icon">✍️</span>
            </h2>
        </div>

        <ul class="sidebar-menu">
            <div class="upper">
                <li class="active">
                    <span class="icon">📊</span>
                    <a href="{{route('author.dashboard')}}">Dashboard</a>
                </li>
                <li>
                    <span class="icon">📝</span>
                    <a href="{{route('author.posts.index')}}">My Posts</a>
                </li>
                <li>
                    <span class="icon">➕</span>
                    <a href="{{route('author.posts.create')}}">Create Post</a>
                </li>
                <li>
                    <span class="icon">📄</span>
                    <a href=" {{ route('author.posts.index', ['status' => 'draft']) }}">Draft</a>
                </li>
            </div>

            <div class="lower">
                <li>
                    <span class="icon">🏠</span>
                    <a href="{{route('home')}}">View Site</a>
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
            </div>
        </ul>

        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Author</div>
            </div>
        </div>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

</body>

</html>