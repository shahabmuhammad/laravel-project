<!DOCTYPE html>
<html lang="en">


@include('front.layouts.header')

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh; 
    }

    main {
        flex: 1;
    }
</style>

<body>

  @include('front.layouts.navbar')

  {{--  Page Content --}}
  <main>
    @yield('content')
  </main>

  
  @include('front.layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
