<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <style>
      @page { 
        margin: 0px;
      }
      @font-face{
        font-family: ipag;
        font-style: normal;
        font-weight: normal;
        src:url('{{ storage_path('fonts/ipag.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipag;
        font-style: normal;
        font-weight: bold;
        src:url('{{ storage_path('fonts/ipag.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipam;
        font-style: normal;
        font-weight: normal;
        src:url('{{ storage_path('fonts/ipam.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipam;
        font-style: normal;
        font-weight: bold;
        src:url('{{ storage_path('fonts/ipam.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipamp;
        font-style: normal;
        font-weight: normal;
        src:url('{{ storage_path('fonts/ipamp.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipamp;
        font-style: normal;
        font-weight: bold;
        src:url('{{ storage_path('fonts/ipamp.ttf')}}') format('truetype');
      }
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
        font-family: ipag;
        padding-left: 5em;
        padding-right: 5em;
        padding-top: 3em;
        padding-bottom: 3em;
      }
      h1 {
        padding: 0.5em;
        margin-top: 0em;
        margin-bottom: 0.5em;
        background-color: rgb(77, 115, 190);
        color: white;
        font-family: ipag;
        font-weight: bold;
        font-size: 14pt;
        text-align: center;
      }
      h2 {
        font-family: ipag;
        font-weight: bold;
        font-size: 18pt;
        padding-left: 1em;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
      }
      h3 {
        font-family: ipag;
        font-weight: bold;
        font-size: 15pt;
        padding-left: 2em;
        padding-top: 1em;
        padding-bottom: 1em;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
      }
      h4 {
        padding-top: 10px;
      }
      article section {
        font-family: ipamp;
        font-size: 11pt;
        text-align: justify;
        /* word-break: keep-all; */
        /* white-space: pre-line; */
        line-break: strict;
        word-wrap: break-word;
        /* overflow-wrap: break-word; */
        /* text-indent: 1em; */
        padding-left: 6em;
        padding-right: 1em;
        line-height: 1.7em;
        margin-top: 0em;
        margin-bottom: 0em;
      }
      /* 目次用 */
      .chapter h2 {
        font-family: ipag;
        font-weight: normal;
        font-size: 22pt;
        color: rgb(77, 115, 190);
        padding-left: 0em;
        margin-top: 2em;
        margin-bottom: 0.5em;
      }
      .chapter h3 {
        font-family: ipam;
        font-weight: normal;
        font-size: 15pt;
        padding: 0em;
        margin-top: 0em;
        margin-bottom: 0.5em;
        position: relative;
        height: 1.25em;
      }
      .chapter h4 {
        font-family: ipam;
        font-weight: normal;
        font-size: 15pt;
        padding-top: 0em;
        padding-left: 2em;
        margin-top: 0em;
        margin-bottom: 0.5em;
        position: relative;
        height: 1.25em;
      }
      .chapter h3 .caption {
        font-family: ipam;
        font-weight: normal;
        font-size: 15pt;
        position: absolute;
        left: 0;
      }
      .chapter h4 .caption {
        font-family: ipam;
        font-weight: normal;
        font-size: 15pt;
        position: absolute;
        left: 2em;
      }
      .chapter .page {
        position: absolute;
        right: 0;
      }

      .chapter section {
        padding: 0px;
      }

      /* 強制改ページ用CSSクラス */
      .page-break {
          page-break-after: always;
      }
    </style>
  </head>
  <body>
    @yield('child')
</body>
</html>
