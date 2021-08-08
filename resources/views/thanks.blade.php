@extends('layouts.layout')

@section('title','サンクスページ')

@section('style_local')
<link rel="stylesheet" href="{{asset('/css/thanks_style.css')}}">
@endsection

@section('style')
<link rel="stylesheet" href="{{secure_asset('/css/thanks_style.css')}}">
@endsection

@section('content')
<main>
  <div class="thanks_wrap">
    <p>会員登録ありがとうございます</p>
    <p><a href="/login" class="thanks_button">ログインする</a></p>
  </div>
</main>
@endsection