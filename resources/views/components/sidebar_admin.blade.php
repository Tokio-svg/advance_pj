<div class="sidebar">
  <p style="margin-top: 100px;">サイドメニュー</p>
  <!-- サイドバーボタン -->
  <div class="sidebar_button shadow">
    <a href="{{ route('admin.user') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/person.png')}}" alt="no image">
        <p>ユーザー管理</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('admin.shop') }}">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>店舗管理</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.register') }}">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>店舗アカウント作成</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow" style="background: rgb(40, 89, 112);">
    <a href="#" onclick="event.preventDefault(); document.getElementById('admin_logout-form').submit();">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/exit.png')}}" alt="no image">
        <p>ログアウト</p>
      </div>
    </a>
    <form id="admin_logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </div>
</div>
