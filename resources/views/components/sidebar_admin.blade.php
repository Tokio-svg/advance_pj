<div class="sidebar" style="margin-top: 100px;">
  <!-- サイドバーボタン -->
  <div class="sidebar_button shadow">
    <a href="{{ route('admin.user') }}">
      <div class="sidebar_button-content">
        <img src="{{putSource('/img/person.png')}}" alt="no image" style="filter: invert(100%) sepia(61%) saturate(0%) hue-rotate(229deg) brightness(107%) contrast(101%);">
        <p>ユーザー管理</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('admin.shop') }}">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>飲食店管理</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('admin.shop.new') }}">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>新規飲食店作成</p>
      </div>
    </a>
  </div>
  <div class="sidebar_button shadow">
    <a href="{{ route('shop.register') }}">
      <div class="sidebar_button-content">
      <img src="{{putSource('/img/shop.png')}}" alt="no image">
        <p>飲食店アカウント作成</p>
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
