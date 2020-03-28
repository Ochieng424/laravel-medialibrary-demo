<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Media Library</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body style="margin: 0; padding: 0">
<div class="container-fluid" style="margin: 0; padding: 0">
    <div id="app" style="margin: 0; padding: 0"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
