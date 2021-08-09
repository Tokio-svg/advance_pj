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
      {{$reservation}}
      @endforeach
    </div>
    <div class="favorite_info">
      <h2>お気に入り店舗</h2>
      @foreach ($favorites as $favorite)
      {{$favorite->shop}}
      @endforeach
    </div>
  </div>
</main>
@endsection