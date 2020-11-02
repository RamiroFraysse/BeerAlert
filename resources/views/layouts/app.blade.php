<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Beer Alert</title>

    <!-- Styles -->
    <link href="{{ asset('css/app2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!--Boostrap-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    
    <link rel="shortcut icon" href="/BeerAlert/public/favicon.ico">
    @if((Route::current()->getName()!='edit'))
        @auth
        <script src="{{ asset('js/appsw.js') }}" defer></script>
        <script src="{{ asset('js/apphome.js') }}" type="text/javascript"></script>
        @endauth
        <link rel="manifest" href="manifest.json"> 
    @endif

   
</head>
<body style =  "height: 100vh; width: 100vw;">
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-dark bg-dark stycky-top">

            {{-- collapse --}}
            <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapse_target">
                
                <ul class="navbar-nav">
                    @if(auth()->user()!=null)
                        @if((Route::current()->getName()=='edit'))
                        <a class="navbar-brand" href="{{ route('home')}}" ><img src="../favicon.ico" alt="home"></a>
                        @else
                        <a class="navbar-brand" href="{{ route('home')}}" ><img src="./favicon.ico" alt="home"></a>
                        @endif
                            <span class="navbar-text">Beer Alert</span>
                        </a>
                    @else
                        <a class="navbar-brand" href="{{ route('welcome')}}" ><img src="./favicon.ico" alt="home"></a>
                        <span class="navbar-text">Beer Alert</span>

                    @endif
                   
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-target="dropdown_target"  data-toggle="dropdown">
                                {{ Auth::user()->name }} <span></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown_target">
                                <a class="dropdown-item" href="{{ route('edit',auth()->user()->id) }}">
                                    Edit
                                </a>
                                <hr>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                           
                        </li>
                        
                    @endguest
                    <li class="nav-item">
      
                        <a href="" class="nav-link" onclick="my_function()">Contact</a>
                    </li>
                    
                    
                </ul>
            </div>
        </nav>
        
        <div class="container">
            @yield('content')
            <!-- /.content-wrapper -->
            
        </div> 
       

        <footer class="main-footer py-3" style="bottom:0;position:fixed;">
            <strong>Copyright &copy; 2019-2024 <a href="">Ramiro Fraysse</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.2-pre
            </div>
        </footer>
    </div>
    
</body>
</html>
