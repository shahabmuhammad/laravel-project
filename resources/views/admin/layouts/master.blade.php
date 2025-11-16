<!doctype html>
<html lang="en">

<head>

    @include('admin.layouts.header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css"
        integrity="sha512-/RUbtHakVMJrg1ILtwvDIceb/cDkk97rWKvfnFSTOmNbytCyEylutDqeEr9adIBye3suD3RfcsXLOLBqYRW4gw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="d-flex flex-grow-1" id="wrapper">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Page Content -->
        <div id="page-content" class="w-100 d-flex flex-column">

            <!-- Navbar -->
            @include('admin.layouts.navbar')

            <!-- Main Content -->
            <main class="flex-fill p-4">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    @include('admin.layouts.script')


</body>

</html>
