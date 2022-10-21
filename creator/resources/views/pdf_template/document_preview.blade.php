<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
        font-style: bold;
        font-weight: bold;
        src:url('{{ storage_path('fonts/ipag.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipamp, sans-serif;
        font-style: normal;
        font-weight: normal;
        src:url('{{ storage_path('fonts/ipamp.ttf')}}') format('truetype');
      }
      @font-face{
        font-family: ipamp, sans-serif;
        font-style: bold;
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
        margin-bottom: 2em;
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
      }
      h3 {
        font-family: ipag;
        font-weight: bold;
        font-size: 15pt;
        padding-left: 2em;
        padding-top: 1em;
        padding-bottom: 1em;
      }
      h4 {
        padding-top: 10px;
      }
      article section {
        font-family: ipamp;
        font-size: 11pt;
        /* word-break: keep-all; */
        line-break: strict;
        word-wrap: break-word;
        /* overflow-wrap: break-word; */
        /* text-indent: 1em; */
        padding-left: 6em;
        padding-right: 1em;
        line-height: 1.7em;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </head>
  <body class="antialiased">
    <div>
      {{-- <div class="col-1"></div> --}}
      <section>
        <h1>事業継続計画</h1>
        <article>
          <h2>1. 総論</h2>
          <div>
            {{-- <div class="col-2"></div> --}}
              <section>
                <p>地震のみならず、大型台風、集中豪雨、大雪による被害など多くの災害を経験し、 近年の我が国は常に自然災害と隣り合わせの状況にあります。地球温暖化による影響も考えられ、事前の予測も難しく、今後も自然災害の発生リスクは一層高まっていっても過言ではありません。</p>
                
<p>そのような中、福祉用具関連サービスは、要介護者、その家族等の生活を支える上で欠かせないものであり、もし突発的な経営環境の変化など不測の事態が発生しても、被害を最小限に食い止め、その後も利用者に必要なサービスを継続的に提供できる体制を構築し備えておくことが重要です。必要な時に必要な福祉用具を必要とされている方に適切な対応と適切に供給できるように、平時から重要な事業を中断させない、あるいは中断しても可能な限り短い期間で復旧させ優先業務 を実施できるための方針、体制、手順等を示した計画をあらかじめ検討して準備や訓練をしておくことが重要です。</p>
              </section>
            </div>
          </div>
        </article>
        <article>
          <h3>1.1 基本方針</h3>
          <div>
              <section>
                全体像<br/>
                「補足5」対応フローチャートを参照。
              </section>
            </div>
          </div>
        </article>
        <article>
          <h3>1.2 推進体制</h3>
          <div>
              <section>
                <p>(平常時の災害対策の推進体制を記載する。)<br/>
                ●継続的かつ効果的に取組みを進めるために推進体制を構築する。<br/>
災害対策は一過性のものではなく、日頃から継続して取り組む必要がある。また災害対策の推進には、総務部などの一部門で進めるのではなく、多くの部門が関与することが効果的である。<br/>
【様式１】推進体制の構成メンバーに体制を記入する。</p>

<p>●被災した場合の対応体制は「３．緊急時の対応」の項目に記載する。<br/>
ここでは平常時における災害対策や事業継続の検討・策定や各種取組を推進する体制を記載する。</p>

<p>●各事業所の実情に即して、既存の検討組織を有効活用する。</p>
              </section>
            </div>
          </div>
        </article>
      </section>
      {{-- <div class="col-1"></div> --}}
    </div>
  </body>
  <script type="text/javascript">
  </script>
</html>
