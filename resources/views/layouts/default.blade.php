<!doctype html>
<html lang="{{ App::currentLocale() }}" dir="{{ App::currentLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (App::currentLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('bootstrap/css/headers.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>{{ config('app.name') }}</title>




    @stack('styles')

</head>

<body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('questions.index') }}"
                            class="nav-link px-2 link-secondary">{{ __('Questions') }}</a></li>
                    @auth
                        <li><a href="{{ route('notifications.index') }}"
                                class="nav-link px-2 link-body-emphasis">{{ __('Notifications') }}</a></li>
                    @endauth
                </ul>


                <form class="col-12 col-md-6  mb-3 mb-lg-0 me-lg-3" id="searchForm" method="get"
                    action="{{ route('questions.index') }}">
                    <div class="input-group">
                        <input type="search" id="searchInput" class="form-control"
                            placeholder="{{ __('Search questions...') }}" name="search" aria-label="Search"
                            style="border-radius: 25px  25px; border-right: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px; transition: all 0.3s ease;">

                    </div>
                </form>

                <!-- Language -->
                <div class="dropdown text-end p-3">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                        id="locale" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('Language') }}
                    </a>
                    {{--                <ul class="dropdown-menu text-small" aria-labelledby="locale"> --}}
                    {{--                    <li><a class="dropdown-item" href="{{URL::current()}}?lang=ar">العربية</a></li> --}}
                    {{--                    <li><a class="dropdown-item" href="{{URL::current()}}?lang=en">English</a></li> --}}
                    <ul class="dropdown-menu text-small" aria-labelledby="locale">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @auth
                    <!-- Notification -->
                    <x-notification-menu>
                    </x-notification-menu>

                    <!-- User -->
                    <div class="dropdown text-end m-2">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->PhotoUrl }}" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('password.edit') }}">{{ __('Change password') }}</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" onclick="document.getElementById('logout').submit()"
                                    href="javascript:;">{{ __('sign out') }}</a></li>
                            <form action="{{ route('logout') }}" method="post" id="logout" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Sign-up') }}</a>
                @endauth


            </div>
        </div>
    </header>

    <div class="container py-5 ">
        <div class="row">
            <h2>@yield('title', 'page Title')</h2>
            @yield('content')
        </div>

        <!-- Notification Toast -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="notification-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="" id="notification-image" style="width: 50px; height: 50px" class="rounded me-2"
                        alt="">
                    <strong class="me-auto" id="notification-title"></strong>
                    <small id="notification-time"></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="notification-body">
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        const userId = "{{ Auth::id() }}"
        $(function() {
            $('#searchInput').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('questions.search') }}",
                        dataType: "json",
                        data: {
                            search: request.term
                        },

                        success: function(data) {
                            var mappedData = $.map(data, function(title, id) {
                                return {
                                    value: title, // Display title in the input field
                                    id: id // Store ID separately for use
                                };
                            });
                            response(mappedData)
                        }
                    });
                },
                minLength: 3, // Minimum characters before triggering autocomplete
                select: function(event, ui) {
                    // When an item is selected, set the input value to the label (title)
                    $('#searchInput').val(ui.item.value); // Title in the input
                    // Redirect using the selected item's ID
                    window.location.href = "{{ route('questions.show', '') }}/" + ui.item.id;
                    return false; // Prevent default behavior
                }
            });
        });
    </script>

    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>

</html>
