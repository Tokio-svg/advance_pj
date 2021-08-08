<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- スタイルシート読み込み -->
  @if(app('env')=='local')
  <link rel="stylesheet" href="{{asset('/css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('/css/common_style.css')}}">
  @yield('style_local')
  @else
  <link rel="stylesheet" href="{{secure_asset('/css/reset.css')}}">
  <link rel="stylesheet" href="{{secure_asset('/css/common_style.css')}}">
  @yield('style')
  @endif
</head>

<body>
  <div id="menu" class="menu">
    <p id="close">×</p>
    <ul>
      <li><a href="/">Home</a></li>
      <!-- ログイン状態で表示を変更する -->
      @if (Auth::check())
      <li>Logout</li>
      <li>Mypage</li>
      @else
      <li><a href="/register">Registration</a></li>
      <li>Login</li>
      @endif
    </ul>
  </div>
  <div class="flex_container">
    <div class="content_wrap">
      <header>
        <div class="header_content">
          <div class="logo_wrap">
            <p id="open">開</p>
            <h1>Rese</h1>
          </div>
          @yield('header_content')
        </div>
      </header>
      @yield('content')
    </div>
    @yield('reservation')
  </div>

  <script>
    // メニュー開閉
    const menu = document.getElementById('menu');
    const open = document.getElementById('open');
    const close = document.getElementById('close');
    open.addEventListener('click', function() {
      menu.style.left = 0;
    });
    close.addEventListener('click', function() {
      menu.style.left = '-100%';
    });
  </script>
</body>

</html>