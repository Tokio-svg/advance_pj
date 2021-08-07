@extends('layouts.layout')

@section('title','飲食店一覧ページ')

@section('style_local')
<link rel="stylesheet" href="{{asset('/css/index_style.css')}}">
@endsection

@section('style')
<link rel="stylesheet" href="{{secure_asset('/css/index_style.css')}}">
@endsection

@section('header_content')
<!-- 検索フォーム -->
<form action="/" method="get">
  <!-- 地域 -->
  <select name="area_id" id="area">
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
  <select name="genre_id" id="genre">
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
  <!-- 店名 -->
  <input type="text" name="shop_name" value="{{$inputs['shop_name']}}">
  <button type="submit">検索</button>
</form>
@endsection

@section('content')
<main>
  @foreach ($shops as $shop)
  <div class="card_wrap">
    <p>{{$shop->image_url}}</p>
    <p>{{$shop->name}}</p>
    <p>{{$shop->area->name}}</p>
    <p>{{$shop->genre->name}}</p>
    <p>詳しく見る</p>
    <p>♥</p>
  </div>
  @endforeach
</main>
@endsection