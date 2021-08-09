@extends('layouts.layout')

@section('title','マイページ')

@section('style_local')
<link rel="stylesheet" href="{{asset('/css/mypage_style.css')}}">
@endsection

@section('style')
<link rel="stylesheet" href="{{secure_asset('/css/mypage_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="user_name">{{$user->name}}さん</h1>
  <div class="mypage_content">
    <div class="reservation_info">
      <h2>予約状況</h2>
      @foreach ($reservations as $reservation)
      <div class="reservation_card">
        <div class="reservation_flex">
          <p>ICON</p>
          <p>予約</p>
          <p onclick="event.preventDefault(); document.getElementById('reservation_{{$reservation->id}}').submit();">×</p>
          <form id="reservation_{{$reservation->id}}" action="/reserve/delete" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
            <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
          </form>
        </div>
        <table>
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
            <td>{{$reservation->number}}</td>
          </tr>
        </table>
      </div>
      @endforeach
    </div>
    <div class="favorite_info">
      <h2>お気に入り店舗</h2>
      <div class="favorite_flex">
        @foreach ($favorites as $favorite)
        <!-- 店舗情報カード -->
        <div class="card_wrap">
          <div class="card_image">
            {{$favorite->shop->image_url}}
          </div>
          <div style="padding: 20px;">
            <h1>{{$favorite->shop->name}}</h1>
            <div class="card_tag">
              #{{$favorite->shop->area->name}}
              #{{$favorite->shop->genre->name}}
            </div>
            <div class="card_flex">
              <div class="card_detail">
                <a href="/detail/{{$favorite->shop->id}}">詳しく見る</a>
              </div>
              <!-- ♥ -->
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</main>
@endsection