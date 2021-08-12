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
</head>

<body>
  <div id="menu" class="menu">
    <p id="close" class="shadow">×</p>
    <ul>
      <li><a href="/">Home</a></li>
      <!-- ログイン状態で表示を変更する -->
      @if (Auth::check())
      <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
      <li><a href="/mypage">Mypage</a></li>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      @else
      <li><a href="/register">Registration</a></li>
      <li><a href="/login">Login</a></li>
      @endif
    </ul>
  </div>
  <div class="flex_container">
    <div class="content_wrap">
      <header>
        <div class="header_content">
          <div class="logo_wrap">
            <p id="open" class="shadow">開</p>
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
  @yield('script')
</body>

</html>