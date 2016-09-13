<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>


    <!-- JavaScripts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="//code.jquery.com/jquery-1.10.2.js"></script>--}}
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/plugins/chosen_v1.5.1/chosen.jquery.js"></script>
    <script src="/js/bootstrap-treeview.js"></script>


    <script src="/js/modal-manager.js"></script>

    {{--<script src="/plugins/jquery-cookie-master/src/jquery.cookie.js"></script>--}}


<!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href="/plugins/chosen_v1.5.1/chosen.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/welcome.css" />

    <!-- Tinymce -->
    {{ HTML::script('/plugins/tinymce/tinymce.min.js') }}

    <style>
        body {
            font-family: 'Lato';
        }

        #app-layout {
            padding-top: 0px;
        }
    </style>

</head>

<body id="app-layout">

@yield('content')
</body>
</html>

