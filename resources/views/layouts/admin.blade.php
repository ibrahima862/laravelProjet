<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>@yield('title', 'Mini E-commerce')</title>
    <!-- Ton CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
    @yield('js')
</head>

<body class="no-scroll">

    {{-- Header commun --}}
   
     
    <main class="">
    <div class="w-full bg-gray-100 py-8">
             
            @yield('content')
       
    </div>
  </main>

    @include('layouts.footer')



</body>

</html>
