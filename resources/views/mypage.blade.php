@extends('layouts.layout')

@section('title','マイページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/mypage_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="user_name">{{$user->name}}さん</h1>
  <div class="mypage_content">
    <div class="reservation_info">
      <h2>予約状況</h2>
      @foreach ($reservations as $reservation)
      <div class="reservation_card shadow">
        <div class="reservation_flex">
          <div>
            <img src="{{putSource('/img/clock.png')}}" alt="no image" style="width: 28px;">
          </div>
          <p>予約{{$loop->index + 1}}</p>
          <div onclick="return confirm('予約を取り消してもよろしいですか？'); document.getElementById('reservation_{{$reservation->id}}').submit();" style="cursor: pointer;" onmouseover="showText('popup_delete',event)" onmouseout="hideText('popup_delete')">
            <img src="{{putSource('/img/cross.png')}}" alt="no image" style="width: 28px;">
          </div>
          <form id="reservation_{{$reservation->id}}" action="/reserve/delete" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
            <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
          </form>
        </div>
        <table class="reservation_table">
          <tr>
            <th>Shop</th>
            <td>{{$reservation->shop->name}}</td>
          </tr>
          <tr>
            <th>Date</th>
            <td>{{$reservation->date}}</td>
          </tr>
          <tr>
            <th>Time</th>
            <td>
              <?php
              $time = substr($reservation->time, 0, 5);
              echo $time;
              ?>
            </td>
          </tr>
          <tr>
            <th>Number</th>
            <td>{{$reservation->number}}人</td>
          </tr>
        </table>
      </div>
      @endforeach
      <p id="popup_delete" class="popup">この予約を取り消します</p>
    </div>
    <div class="favorite_info">
      <h2>お気に入り店舗</h2>
      <div class="favorite_flex">
        @foreach ($favorites as $favorite)
        <!-- 店舗情報カード -->
        <div class="card_wrap shadow">
          <div class="card_image" style="background-image: url({{$favorite->shop->image_url}});">
          </div>
          <div style="padding: 20px;">
            <h1 class="card_name">{{$favorite->shop->name}}</h1>
            <div class="card_tag">
              <a href="/?area_id={{$favorite->shop->area_id}}">#{{$favorite->shop->area->name}}</a>
              <a href="/?genre_id={{$favorite->shop->genre_id}}">#{{$favorite->shop->genre->name}}</a>
            </div>
            <div class="card_flex">
              <div class="card_detail">
                <a href="/detail/{{$favorite->shop->id}}">詳しく見る</a>
              </div>
              <!-- メモ：POST送信でfavoritesレコードを削除後現在のURLにリダイレクト -->
              <div onclick="event.preventDefault(); document.getElementById('shop_{{$favorite->shop->id}}').submit();" style="cursor: pointer;" onmouseover="showText('favorite_popup-delete',event)" onmouseout="hideText('favorite_popup-delete')">
                <img src="{{putSource('/img/heart_red.png')}}" alt="no image">
              </div>
              <form id="shop_{{$favorite->shop->id}}" action="/favorite/delete" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="hidden" name="shop_id" value="{{$favorite->shop->id}}">
                <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
              </form>
            </div>
          </div>
        </div>
        @endforeach
        <p id="favorite_popup-delete" class="popup">お気に入り登録を解除します</p>
      </div>
    </div>
  </div>
</main>
@endsection