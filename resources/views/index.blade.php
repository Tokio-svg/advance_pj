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
<div class="search_wrap">
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
    <span>◎</span>
    <!-- 店名 -->
    <input type="text" name="shop_name" value="{{$inputs['shop_name']}}" placeholder="Search ...">
    <button type="submit">検索</button>
  </form>
</div>
@endsection

@section('content')
<main>
  @foreach ($shops as $shop)
  <div class="card_wrap">
    <div class="card_image">
      {{$shop->image_url}}
    </div>
    <div style="padding: 20px;">
      <h1>{{$shop->name}}</h1>
      <div class="card_tag">
        #{{$shop->area->name}}
        #{{$shop->genre->name}}
      </div>
      <div class="card_flex">
        <div class="card_detail">
          <a href="/detail/{{$shop->id}}">詳しく見る</a>
        </div>
        <p>♥</p>
      </div>
    </div>
  </div>
  @endforeach
</main>
@endsection