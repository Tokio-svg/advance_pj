@extends('layouts.layout')

@section('title','飲食店一覧ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/index_style.css')}}">
@endsection

@section('header_content')
<!-- 検索フォーム -->
<div class="search_wrap">
  <form action="/" method="get" id="search">
    <!-- 地域 -->
    <select name="area_id" id="area" onchange="document.getElementById('search').submit();">
      <option value="">All area</option>
      @foreach ($areas as $area)
      <!-- IDが入力値と同じ場合は初期値に設定 -->
      @if ($area->id == $inputs['area_id'])
      <option value="{{$area->id}}" selected>{{$area->name}}</option>
      @else
      <option value="{{$area->id}}">{{$area->name}}</option>
      @endif
      @endforeach
    </select>
    <!-- ジャンル -->
    <select name="genre_id" id="genre" onchange="document.getElementById('search').submit();">
      <option value="">All genre</option>
      @foreach ($genres as $genre)
      <!-- IDが入力値と同じ場合は初期値に設定 -->
      @if ($genre->id == $inputs['genre_id'])
      <option value="{{$genre->id}}" selected>{{$genre->name}}</option>
      @else
      <option value="{{$genre->id}}">{{$genre->name}}</option>
      @endif
      @endforeach
    </select>
    <!-- アイコン -->
    <img src="{{putSource('/img/search.png')}}" alt="no image" style="width: 16px;">
    <!-- 店名 -->
    <input type="text" name="shop_name" value="{{$inputs['shop_name']}}" placeholder="Search ..." onchange="document.getElementById('search').submit();">
  </form>
</div>
@endsection

@section('content')
<main>
  @foreach ($shops as $shop)
  <!-- 店舗情報カード -->
  <div class="card_wrap">
    <div class="card_image">
      {{$shop->image_url}}
    </div>
    <div style="padding: 20px;">
      <h1>{{$shop->name}}</h1>
      <div class="card_tag">
        <a href="/?area_id={{$shop->area_id}}">#{{$shop->area->name}}</a>
        <a href="/?genre_id={{$shop->genre_id}}">#{{$shop->genre->name}}</a>
      </div>
      <div class="card_flex">
        <div class="card_detail">
          <a href="/detail/{{$shop->id}}">詳しく見る</a>
        </div>
        @if (Auth::check())
        @if (empty($shop->favorites[0]))
        <!-- メモ：POST送信でfavoritesレコードを挿入後現在のURLにリダイレクト -->
        <div onclick="setPosition('position_add'); setShopId('shop_fav-add', '{{$shop->id}}'); document.getElementById('favorite_add').submit();" style="cursor: pointer;">
          <img src="{{putSource('/img/heart.png')}}" alt="no image">
        </div>
        @else
        <!-- メモ：POST送信でfavoritesレコードを削除後現在のURLにリダイレクト -->
        <div onclick="setPosition('position_delete'); setShopId('shop_fav-delete', '{{$shop->id}}'); document.getElementById('favorite_delete').submit();" style="cursor: pointer;">
          <img src="{{putSource('/img/heart_red.png')}}" alt="no image">
        </div>
        @endif
        @endif
      </div>
    </div>
  </div>
  @endforeach
  <!-- お気に入り処理用フォーム -->
  @if (Auth::check())
  <!-- 登録用 -->
  <form id="favorite_add" action="/favorite/add" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <input type="hidden" name="shop_id" value="" id="shop_fav-add">
    <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
    <input type="hidden" name="position" value="0" id="position_add">
  </form>
  <!-- 削除用 -->
  <form id="favorite_delete" action="/favorite/delete" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <input type="hidden" name="shop_id" value="" id="shop_fav-delete">
    <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
    <input type="hidden" name="position" value="0" id="position_delete">
  </form>
  @endif
</main>
@endsection

@section('script')
<script>
  // 読み込み時にスクロール位置を$positionにセット
  window.onload = function() {
    window.scrollTo(0, <?php echo $position ?>);
  }

  // 関数：指定したid要素のvalueに現在のスクロール位置を格納
  function setPosition(id) {
    let input = document.getElementById(id);
    input.value = window.scrollY;
  }

  // 関数：指定したid要素のvalueにshopIdを格納
  function setShopId(id, shopId) {
    let input = document.getElementById(id);
    input.value = shopId;
  }
</script>
@endsection