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
        <a href="/admin">
          <div class="sidebar_button-content">
            <img src="{{putSource('/img/person.png')}}" alt="no image">
            <p>ユーザー管理</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow">
        <a href="/admin/shop">
          <div class="sidebar_button-content">
            <p>店舗管理</p>
          </div>
        </a>
      </div>
    </div>
    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <p style="margin-top: 100px;">検索フォーム</p>
          <form action="/admin/shop" method="get">
            <!-- 飲食店名 -->
            <label for="name">飲食店名</label>
            <input type="text" name="name" id="name" value="{{$inputs['name']}}">
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
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
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