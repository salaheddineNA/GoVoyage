<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoVoyage</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/images/favicon.ico') }}">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body>

@include('partials.header')

@include('components.hero')

@include('components.about')

@include('components.compagniesaeriennes')

@include('components.offer')

@include('components.calltoaction')

@include('partials.footer')


</body>
</html>
