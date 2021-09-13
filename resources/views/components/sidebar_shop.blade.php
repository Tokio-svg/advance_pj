<div class="sidebar">
  <p style="margin-top: 100px;">サイドメニュー</p>
  <!-- サイドバーボタン -->
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.top') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>店舗情報</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.reservation') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/calendar.png')}}" alt="no image">
        <p>予約情報</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.favorite') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/heart_red.png')}}" alt="no image">
        <p>お気に入り情報</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.evaluation') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/star_5.png')}}" alt="no image">
        <p>評価情報</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="#" onclick="event.preventDefault(); document.getElementById('admin_logout-form').submit();">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/exit.png')}}" alt="no image">
        <p>ログアウト</p>
      </div>
    </a>
    <form id="admin_logout-form" action="{{ route('shop.logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </div>
</div>
