<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh; margin: 0; overflow-x:hidden;">


<x-header :search="$search ?? ''" />


<main style="flex: 1;">
    @yield('content')
</main>


<x-footer/>

</body>
</html>

<style>
    ::-webkit-scrollbar {
        display: none;
    }
</style>
