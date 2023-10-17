<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
             
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    <a class="navbar-brand" href="{{('home') }}">{{ __('Home') }}</a>


                <a href="{{route('products.index')}}" class="navbar-brand">Products</a>
                <a href="{{route('category.index')}}" class="navbar-brand">Users</a>
                <a href="{{route('category.store')}}" class="navbar-brand">Manual Order</a>
                <a href="{{route('category.index')}}" class="navbar-brand">Checks</a>
                <a href="{{route('category.index')}}" class="navbar-brand">Orders </a>
                <a href="{{route('category.index')}}" class="navbar-brand">Cart </a>
                <a href="{{route('category.create')}}" class="navbar-brand">Add category</a>

                
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                          

                              
                        <!-- Authentication Links -->
                        
                  
        
                           
                     @guest
                  
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif

                          
                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="position:relative; padding-left:50px;">
                        <!--  <img src="{{asset('image/'.'zara1.jpg' )}}" style="width: 32px; height: 32px; position: absolute; top: 10px; left: 10px; border-radius:50%;">   --> 
                        <!--   <img src="{{asset('images/avatars/'.$user->image)}}" style="width: 32px; height: 32px; position: absolute; top: 10px; left: 10px; border-radius:50%;"> -->
                        admin
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="" >{{__('Profile')}}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        
        <div class="bg-danger text-white">
              @yield('body')

        </div>
    </div>
</body>
</html>
