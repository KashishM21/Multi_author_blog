<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

</head>

<body>
    <header class="navbar">
        <div class="nav-container">

            <div class="logo">
                MultiAuthorBlog
            </div>
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="active">Home</a>

                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="btn">Register</a>
                @else
                    @if (auth()->user()->role === 'author')
                        <a href="{{ route('author.dashboard') }}">Dashboard</a>
                        <a href="{{ route('author.posts.index') }}">My Posts</a>
                    @endif

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.posts.index') }}">All Posts</a>
                        <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                    @endif

                    <a href="{{ route('profile.edit') }}">Profile</a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @endguest
            </nav>

        </div>
    </header>

</body>

</html>
