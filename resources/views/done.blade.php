@extends('layouts.layout')

@section('title','予約完了ページ')

@section('style_local')
<link rel="stylesheet" href="{{asset('/css/thanks_style.css')}}">
@endsection

@section('style')
<link rel="stylesheet" href="{{secure_asset('/css/thanks_style.css')}}">
@endsection

@section('content')
<main>
  <div class="thanks_wrap">
    <p>ご予約ありがとうございます</p>
    <p><a href="/" class="thanks_button">戻る</a></p>
  </div>
</main>
@endsection