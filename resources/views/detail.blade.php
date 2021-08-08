@extends('layouts.layout')

@section('title','飲食店詳細ページ')

@section('style_local')
<link rel="stylesheet" href="{{asset('/css/detail_style.css')}}">
@endsection

@section('style')
<link rel="stylesheet" href="{{secure_asset('/css/detail_style.css')}}">
@endsection

@section('content')
<main>
  <div style="display: flex;">
    <a href="/">＜</a>
    <h1>{{$shop->name}}</h1>
  </div>
  <div class="image">
    <p>{{$shop->image_url}}</p>
  </div>
  <div class="tag">
    #{{$shop->area->name}}
    #{{$shop->genre->name}}
  </div>
  <p>{{$shop->overview}}</p>
</main>
@endsection

@section('reservation')
<div class="reservation_wrap">
  <h1>予約</h1>
  <form action="/done" method="post">
    @csrf
    <div>
      <input type="date" name="date" id="date">
    </div>
    <div>
      <select name="time" id="time">
        <?php
        for ($i = 0; $i < 24; $i++) {
          echo "<option value='" . $i . "'>" . $i . ":00</option>";
        }
        ?>
      </select>
    </div>
    <div>
      <select name="number" id="number">
        <?php
        for ($i = 1; $i < 11; $i++) {
          echo "<option value='" . $i . "'>" . $i . "人</option>";
        }
        ?>
      </select>
    </div>
    <div class="reservation_confirm">
      <table>
        <tr>
          <th>Shop</th>
          <td>{{$shop->name}}</td>
        </tr>
        <tr>
          <th>Date</th>
          <td>2021-08-07</td>
        </tr>
        <tr>
          <th>Time</th>
          <td>00:00</td>
        </tr>
        <tr>
          <th>Number</th>
          <td>1人</td>
        </tr>
      </table>
    </div>
    <div>
      @if (Auth::check())
      <button type="submit">予約する</button>
      @else
      <p>予約をご希望の方はログインしてください</p>
      @endif
    </div>
  </form>
</div>
@endsection