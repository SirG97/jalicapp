<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="">
    <div id="hamburger" class="navigation-menu">
        <svg width="20px" height="20px" viewBox="0 0 69 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill-rule="evenodd">
                <g fill-rule="nonzero" stroke="none">
                    <g>
                        <rect x="0" y="0" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="22" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="44.7927667" width="69" height="6.2072333" rx="3.10361665"></rect>
                    </g>
                </g>
            </g>
        </svg>
    </div>
    <nav class="nav nav-sidebar">
        <div class="nav_section">
            <div class="nav_section_content company">
                <div class="nav_item prelative">
                    <a href="" class="nav_flex">
                            <span class="company-icon d-flex justify-content-center align-items-center">
                                <img src="{{ asset('img/hohlogo.jpeg') }}" alt="Logo" style="width: 25px; border-radius: 50%;">
                            </span>
                        <span class="company_text font-weight-bold">Home Of Honesty</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="nav_section margin-fix scroll-menu">
            <div class="nav_section_content">
                <div class="nav_item prelative">
                    <a href="/dashboard" class="nav_link nav_flex {{request()->is('/dashboard') ? 'active': ''}}">
                           <span class="nav_link_icon">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                           </span>
                        <span class="nav_link_text">Dashboard</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/profile" class="nav_link nav_flex {{request()->is('/profile') ? 'active': ''}}">
                           <span class="nav_link_icon">
                            <i class="fas fa-fw fa-user"></i>
                           </span>
                        <span class="nav_link_text">Profile</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/customers" class="nav_link nav_flex {{ request()->is('/customers')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-users"></i>
                            </span>
                        <span class="nav_link_text">Customers</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/customer/new" class="nav_link nav_flex {{ request()->is('/customer/new') ? 'active': ''}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-user-plus"></i>
                            </span>
                        <span class="nav_link_text">New Customer</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/staff" class="nav_link nav_flex {{ request()->is('/staff') ? 'active': ''}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-headset"></i>
                            </span>
                        <span class="nav_link_text">Staff</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="{{ route('new') }}" class="nav_link nav_flex {{ request()->is('/new_staff') ? 'active': ''}}">
                        <span class="nav_link_icon">
                         <i class="fas fa-fw fa-user-lock"></i>
                        </span>
                        <span class="nav_link_text">New Staff</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/contributions" class="nav_link nav_flex {{ request()->is('/contributions') ? 'active': ''}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-user-plus"></i>
                            </span>
                        <span class="nav_link_text">Contributions</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/contribute" class="nav_link nav_flex {{ request()->is('/contribute') ? 'active': ''}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-paper-plane"></i>
                            </span>
                        <span class="nav_link_text">Mark Contribution</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/message" class="nav_link nav_flex {{ request()->is('/message') ? 'active': ''}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-envelope"></i>

                            </span>
                        <span class="nav_link_text">Send SMS</span>
                    </a>
                </div>

{{--                <div class="nav_item prelative">--}}
{{--                    <a href="/settings" class="nav_link nav_flex {{ request()->is('/settings') ? 'active': ''}}">--}}
{{--                            <span class="nav_link_icon">--}}
{{--                             <i class="fas fa-fw fa-cogs"></i>--}}
{{--                            </span>--}}
{{--                        <span class="nav_link_text">Settings</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
                <div class="nav_item prelative">
                    <a class="nav_link nav_flex" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                         <span class="nav_link_icon">
                          <i class="fas fa-fw fa-sign-out-alt"></i>
                         </span>
                        <span class="nav_link_text" >Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>
<header class="d-flex">
    <div class="header-page-title mr-auto">
        <div class="icon-block blue-bg">
            <img src="{{ asset('img/hohlogo.jpeg') }}" alt="Logo" style="width: 35px; border-radius: 50%;">
        </div>
        <span class="header-page-title-text">@yield('title')</span>
    </div>

    <div class="header-nav">
            <span class="header-nav-item">
                <img class="avatar rounded-circle img-thumbnail img-fluid" src="/" alt="profile pics">
{{--            <p class="avatar">Hi! Noble</p>--}}
            </span>
        <div class="nav-dropdown">
            <div class="nav-dropdown-item">
                <a href="/profile">
                    <div class="nav-dropdown-item-link">
                        Profile
                    </div>
                </a>
            </div>
            <div class="nav-dropdown-item">
                <a href="/settings">
                    <div class="nav-dropdown-item-link">
                        Settings
                    </div>
                </a>
            </div>
            <div class="nav-dropdown-item">
                <a href="/logout">
                    <div class="nav-dropdown-item-link">
                        Logout
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>
<main class="main" id="main">
    <div class="main_container">
        @yield('content')
    </div>
</main>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
