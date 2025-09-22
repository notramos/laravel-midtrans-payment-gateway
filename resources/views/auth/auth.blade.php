<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <title>CV. AXEL DIGITAL CREATIVE</title>
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>
    @yield('content')
</body>
</html>