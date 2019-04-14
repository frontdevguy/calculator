<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Basic Calculator</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,500,600,700" rel="stylesheet">

        <!-- Styles -->
        @include('style')
    </head>
    <body>
        <!-- Main Content -->
        @include('main')

        <!-- JavaScript -->
        @include('script')
    </body>
</html>
