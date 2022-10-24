<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="referrer" content="always">
  <link rel="canonical" href="/login">
  <link rel="shortcut icon" type="image/jpg" href="https://i.imgur.com/UyXqJLi.png" />
  <title>{{ $title }}</title>
  @vite('resources/css/app.css')
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  @vite('resources/js/app.js')
</head>

<body>
  @yield('content')
</body>

</html>
