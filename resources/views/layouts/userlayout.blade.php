
<!DOCTYPE html>
<!--
Template Name: Rubick - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('assets/dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Rubick admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Rubick Admin Template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/app.css') }}" />
        <!-- END: CSS Assets-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <!-- END: Head -->
    <body class="main">
        
        <div class="flex">
            <div class="content">
                <div class="top-bar" style="display:flex;justify-content:end;">
                    <div style="margin-right:20rem;">
                        <ul style="display:flex;">
                            <li style="margin-right:3rem;"><a href="/home">HOME</a></li>
                            <li style="margin-right:3rem;"><a href="/watch">WATCH</a></li>
                            <li><a href="/plans">PLANS</a></li>
                        </ul>
                    </div>
                    <div class="intro-x dropdown w-8 h-8" >
                    
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
                            <img alt="Rubick Tailwind HTML Admin Template" src="{{ asset('assets/dist/images/profile-6.jpg') }}">
                        </div>
                        <div class="dropdown-menu w-56">
                            <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
                                <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                </div>

                                <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                       <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <!-- <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a> -->
                                </div>
                               <!-- <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                                </div>  -->
                            </div>
                        </div>
                    </div>
                </div>

               @yield('content')
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
      <!--   <div data-url="side-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
           <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div> 
            <div class="dark-mode-switcher__toggle border"></div>
        </div>-->
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        @yield('scripts')
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="{{ asset('assets/dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
    </body>
</html>