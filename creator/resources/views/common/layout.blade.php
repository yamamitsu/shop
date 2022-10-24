<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <style>
            a {
                padding: 0 .3em;
                transition: all .3s;
                text-decoration: underline;
                color: blue;
            }
            a:hover {
                color: #fff;
                background-color: #2ecc71;
            }
            body {
                font-family: 'Nunito', sans-serif;
            }
            h3 {
                padding-top: 10px;
            }
            h4 {
                padding-top: 10px;
            }
            .bcp-image-input {
                position: relative;
                padding: 1rem;
                /* margin: 1rem -0.75rem 0; */
                margin: 0px;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      @yield('child')
    </body>
    <script type="text/javascript">
    </script>
</html>
