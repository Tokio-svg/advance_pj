@extends('layouts.layout')

@section('title','店舗管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="sidebar">
      <p style="margin-top: 100px;">サイドメニュー</p>
      <div class="sidebar_button shadow">
        <div class="sidebar_button-content">
          <img src="{{putSource('/img/person.png')}}" alt="no image">
          <p>ユーザー管理</p>
        </div>
      </div>
      <div class="sidebar_button shadow">
        <div class="sidebar_button-content">
          <p>店舗管理</p>
        </div>
      </div>
    </div>
    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <p style="margin-top: 100px;">検索フォーム</p>
          <form action="/admin/shop" method="get">
            <!-- 飲食店名 -->
            <label for="name">飲食店名</label>
            <input type="text" name="name" id="name">
            <!-- 検索ボタン -->
            <div>
              <button type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div>
            <a href="/admin/shop">クリア</a>
          </div>
        </div>
      </div>
      <div class="result_wrap">
        <div class="result_content">
          検索結果
          {{$items->appends(request()->query())->links('vendor.pagination.default_custom')}}
          <table class="result_table">
            <tr>
              <th>ID</th>
              <th>name</th>
              <th>area</th>
              <th>genre</th>
              <th>created_at</th>
            </tr>
            @foreach($items as $shop)
              <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->name}}</td>
                <td>{{$shop->area->name}}</td>
                <td>{{$shop->genre->name}}</td>
                <td>{{$shop->created_at}}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </main>
@endsection