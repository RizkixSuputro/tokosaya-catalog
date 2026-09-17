<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" type="icon" href="assets/images/favicon.png" />
    <title>@yield('judul', config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/tailstore/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tailstore/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tailstore/css/custom.css') }}">
</head>

<body>

    @include('user-front.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('user-front.partials.footer')


    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('assets/tailstore/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/tailstore/js/script.js') }}"></script>

</body>

</html>
