@extends('layouts.layout')

@section('title','登録情報変更完了ページ')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/thanks_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="thanks_wrap">
      <p>{{$message}}</p>
      <p><a href="{{$url}}" class="thanks_button">戻る</a></p>
    </div>
  </main>
@endsection