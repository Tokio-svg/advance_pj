@extends('layouts.layout')

@section('title','飲食店作成完了ページ')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/thanks_style.css')}}">
  <style>
    .thanks_wrap p {
      font-size: 16px;
      margin: 0 auto 30px;
    }
  </style>
@endsection

@section('content')
  <main>
    <div class="thanks_wrap">
      <p>{{$shop_name}}様の飲食店情報を作成しました</p>
      <p>引き続き管理用のアカウントを作成してください</p>
      <p><a href="{{ route('shop.register') }}" class="thanks_button">管理用アカウント作成</a></p>
    </div>
  </main>
@endsection