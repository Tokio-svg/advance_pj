@extends('layouts.layout_admin')

@section('title','飲食店新規作成画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
  <style>
    .sidebar_button:nth-of-type(3) {
      background: rgb(0, 36, 145);
    }
  </style>
@endsection

@section('content')
  <main>
    @component('components.sidebar_admin')
    @endcomponent
    <div class="content_wrap">
      <h2 class="content_title">飲食店新規作成</h2>
      <form action="{{ route('admin.shop.create') }}" method="post">
        @csrf
        <div style="text-align: center; margin-top: 50px;">
          <p>入力した名前で新規飲食店を仮作成します</p>
          <label for="name">名前</label>
          <input type="text" name="name" id="name" value="新規飲食店">
          <button class="button_search" type="submit">作成</button>
        </div>
      </form>
    </div>
  </main>
@endsection

@section('script')
  <script>
  </script>
@endsection