@props(['title' => config('app.name'), 'breadcrumbs' => []])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ env('APP_NAME') }} - {{ env('APP_DESC') }}">
    <meta name="author" content="{{ env('APP_AUTHOR') }}">
    <meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
    
    <title>@yield('title', config('app.name'))</title>
    
    <!-- color-modes:js -->
    <script src="{{ asset('/') }}assets/js/color-modes.js"></script>
    <!-- endinject -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
    <!-- End fonts -->
    
    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/core/core.css">
    <!-- endinject -->
    
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/flatpickr/flatpickr.min.css">
    <!-- End plugin css for this page -->
    
    <!-- inject:css -->
    <!-- endinject -->
    
    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo1/style.css">
    <!-- End layout styles -->
    
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png" />
    
</head>
<body>
    <div class="main-wrapper">
        
        <!-- partial:partials/_sidebar.html -->
        <x-sidebar />
        <!-- partial -->
        
        <div class="page-wrapper">
            
            <!-- partial:partials/_navbar.html -->
            <x-navbar />
            <!-- partial -->
            
            <div class="page-content container-xxl">
                @if ($breadcrumbs)
                    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
                @endif

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h4 class="mb-3 mb-md-0">{{ $title }}</h4>
                    </div>
                </div>

                {{ $slot }}
            </div>
            
            <!-- partial:partials/_footer.html -->
            <x-footer />
            <!-- partial -->
            
        </div>
    </div>
    
    <!-- core:js -->
    <script src="{{ asset('/') }}assets/vendors/core/core.js"></script>
    <!-- endinject -->
    
    <!-- Plugin js for this page -->
    <script src="{{ asset('/') }}assets/vendors/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('/') }}assets/vendors/apexcharts/apexcharts.min.js"></script>
    <!-- End plugin js for this page -->
    
    <!-- inject:js -->
    <script src="{{ asset('/') }}assets/js/app.js"></script>
    <!-- endinject -->
    
    <!-- Custom js for this page -->
    <script src="{{ asset('/') }}assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>
</html>    