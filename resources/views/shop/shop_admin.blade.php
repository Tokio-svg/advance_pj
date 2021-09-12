@extends('layouts.layout')

@section('title','飲食店管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="sidebar">
      <p style="margin-top: 100px;">サイドメニュー</p>
      <p>店名：{{$shop->name}}</p>
      <!-- サイドバーボタン -->
      <div class="sidebar_button shadow" style="background: rgb(53, 96, 246);">
        <a href="{{ route('shop.top') }}">
          <div class="sidebar_button-content">
            <img src="{{putSource('/img/shop.png')}}" alt="no image">
            <p>店舗情報</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow" style="background: rgb(53, 96, 246);">
        <a href="{{ route('shop.top') }}">
          <div class="sidebar_button-content">
            <img src="{{putSource('/img/calendar.png')}}" alt="no image">
            <p>予約情報</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow" style="background: rgb(53, 96, 246);">
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
      店舗情報
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