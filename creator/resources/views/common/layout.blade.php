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
        </style>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
    @yield('child')
    </body>
    <script type="text/javascript">
        window.addEventListener("DOMContentLoaded", () => {
            // textareaタグを全て取得
            const textareaEls = document.querySelectorAll("textarea");

            textareaEls.forEach((textareaEl) => {
                // デフォルト値としてスタイル属性を付与
                textareaEl.setAttribute("style", `height: ${textareaEl.scrollHeight+20}px;`);
                // inputイベントが発生するたびに関数呼び出し
                textareaEl.addEventListener("input", setTextareaHeight);
            });

            // textareaの高さを計算して指定する関数
            function setTextareaHeight() {
                this.style.height = "auto";
                this.style.height = `${this.scrollHeight}px`;
            }
        });
    </script>
</html>
