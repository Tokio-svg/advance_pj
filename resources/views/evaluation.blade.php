@extends('layouts.layout')

@section('title','評価投稿ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/detail_style.css')}}">
@endsection

@section('content')
<main>
  <div class="info_title" style="display: flex;">
    <a href="/detail/{{$shop->id}}" class="back shadow">＜</a>
    <h1 class="shop_name">{{$shop->name}}</h1>
  </div>
  <div class="image">
    <img src="{{$shop->image_url}}" alt="no image">
  </div>
  <div class="tag">
    <a href="/?area_id={{$shop->area_id}}">#{{$shop->area->name}}</a>
    <a href="/?genre_id={{$shop->genre_id}}">#{{$shop->genre->name}}</a>
  </div>
  <p>{{$shop->overview}}</p>
</main>
@endsection

@section('reservation')
<div class="evaluation_form" style="width: 50%;">
  <form action="/evaluation" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <input type="hidden" name="shop_id" value="{{$shop->id}}">
    <input type="hidden" name="url" value="/detail/{{$shop->id}}">
    <div class="grade_wrap">
      <p>評価</p>
      <select name="grade" id="grade">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </div>
    <div class="comment_wrap">
      <p>コメント</p>
      <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    </div>
    <input type="submit" value="送信">
  </form>
</div>
@endsection

@section('script')
<script>
  // 関数：入力必須バリデーション
  function validateRequire(id, errorId) {
    const errorMessage = document.getElementById(errorId);
    const input = document.getElementById(id).value;
    if (!input) {
      errorMessage.style.display = "block";
    } else {
      errorMessage.style.display = "none";
    }
  }
</script>
@endsection