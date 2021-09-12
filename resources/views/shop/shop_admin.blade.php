@extends('layouts.layout')

@section('title','飲食店管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="sidebar">
      <p style="margin-top: 100px;">サイドメニュー</p>
      <!-- サイドバーボタン -->
      <div class="sidebar_button shadow button_push">
        <div class="sidebar_button-content">
          <img src="{{putSource('/img/shop.png')}}" alt="no image">
          <p>店舗情報</p>
        </div>
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
    <div class="content_wrap">
      <p style="margin-top: 100px;">店舗情報</p>
      <div class="shop_info-flex">
        <img class="shop_image" src="{{$shop->image_url}}" alt="no_image">
        <table class="shop_info">
          <tr>
            <th>名前</th>
            <td>{{$shop->name}}</td>
          </tr>
          <tr>
            <th>地域</th>
            <td>{{$shop->area->name}}</td>
          </tr>
          <tr>
            <th>ジャンル</th>
            <td>{{$shop->genre->name}}</td>
          </tr>
          <tr>
            <th>紹介文</th>
            <td>{{$shop->overview}}</td>
          </tr>
        </table>
      </div>
    </div>
  </main>
@endsection

@section('script')
  <script>
    // 関数：削除の確認ダイアログを表示
    function confirmDelete() {
      if (!window.confirm("本当に削除してもよろしいですか？")) {
        return false;
      }
    }

  </script>
@endsection