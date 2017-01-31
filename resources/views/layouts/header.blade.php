<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/bootstrap/bootstrapValidator.min.css" />
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/font-awsome/css/font-awesome.min.css">
    <!-- Scripts-->
    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/javascript" src="/js/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>


    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
  @yield('content')
</body>
</html>
