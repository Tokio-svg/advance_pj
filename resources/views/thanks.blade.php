@extends('layouts.layout')

@section('title','サンクスページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/thanks_style.css')}}">
@endsection

@section('content')
<main>
  <div class="thanks_wrap">
    <p>会員登録ありがとうございます</p>
    <p><a href="/login" class="thanks_button">ログインする</a></p>
  </div>
</main>
@endsection