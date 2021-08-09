@extends('layouts.layout')

@section('title','飲食店詳細ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/detail_style.css')}}">
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
    <a href="/?area_id={{$shop->area_id}}">#{{$shop->area->name}}</a>
    <a href="/?genre_id={{$shop->genre_id}}">#{{$shop->genre->name}}</a>
  </div>
  <p>{{$shop->overview}}</p>
</main>
@endsection
@section('reservation')
<div class="reservation_wrap">
  <h1>予約</h1>
  <form action="/reserve" method="post">
    @csrf
    @if (Auth::check())
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    @endif
    <input type="hidden" name="shop_id" value="{{$shop->id}}">
    <div>
      <input type="date" name="date" id="date" onchange="changeDate(this.value)">
    </div>
    <div>
      <input type="time" name="time" id="time" onchange="changeTime(this.value)">
    </div>
    <div>
      <select name="number" id="number" onchange="changeNumber(this.value)">
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
          <td><span id="date_display"></span></td>
        </tr>
        <tr>
          <th>Time</th>
          <td><span id="time_display"></span></td>
        </tr>
        <tr>
          <th>Number</th>
          <td><span id="number_display">1人</span></td>
        </tr>
      </table>
    </div>
    <div class="submit">
      @if (Auth::check())
      <button type="submit">予約する</button>
      @else
      <p>予約をご希望の方はログインしてください</p>
      @endif
    </div>
  </form>
</div>
@endsection

@section('script')
<script>
  // 関数：name=dateの値を対応するタグに反映する
  function changeDate(value) {
    document.getElementById('date_display').textContent = value;
  }
  // 関数：name=timeの値を対応するタグに反映する
  function changeTime(value) {
    document.getElementById('time_display').textContent = value;
  }
  // 関数：name=numberの値を対応するタグに反映する
  function changeNumber(value) {
    document.getElementById('number_display').textContent = value + '人';
  }
</script>
@endsection