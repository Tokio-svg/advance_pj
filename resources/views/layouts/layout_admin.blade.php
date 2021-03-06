<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="{{putSource('/css/reset.css')}}">
  <link rel="stylesheet" href="{{putSource('/css/common_style.css')}}">
  @yield('style')
  <style>
    .logo_wrap {
      top: 25px;
    }
    #open {
      cursor: unset;
    }
  </style>
</head>

<body>
  <div class="flex_container">
    <div class="content_wrap">
      <header>
        <div class="header_content">
          <div class="logo_wrap">
            <a href="/" style="display: flex;">
              <p id="open" class="shadow">
                <img src="{{putSource('/img/menu.png')}}" alt="no image">
              </p>
              <h1>Rese</h1>
            </a>
          </div>
          @yield('header_content')
        </div>
      </header>
      @yield('content')
    </div>
    @yield('reservation')
  </div>
  @yield('evaluation')


  <script>
    // メニュー開閉
    // const menu = document.getElementById('menu');
    // const open = document.getElementById('open');
    // const close = document.getElementById('close');
    // open.addEventListener('click', function() {
    //   menu.style.left = 0;
    // });
    // close.addEventListener('click', function() {
    //   menu.style.left = '-100%';
    // });

    // 関数：引数のID要素を表示する
    function showText(textId, event) {
      const text = document.getElementById(textId);
      text.style.display = 'block';
      text.style.top = `${event.clientY - 30}px`;
      text.style.left = `${event.clientX}px`;
    }

    // 関数：引数のID要素を非表示にする
    function hideText(textId) {
      document.getElementById(textId).style.display = 'none';
    }
  </script>
  @yield('script')
</body>

</html>