@extends('layouts.layout')

@section('title','ユーザー管理画面')

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
          <form action="/admin" method="get">
            <!-- ユーザーネーム -->
            <div>
              <label for="name">ユーザーネーム</label>
              <input type="text" name="name" id="name" value="{{$inputs['name']}}">
            </div>
            <!-- メールアドレス -->
            <div>
              <label for="email">メールアドレス</label>
              <input type="text" name="email" id="email" value="{{$inputs['email']}}">
            </div>
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div>
            <a href="/admin">クリア</a>
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
              <th>email</th>
              <th>created_at</th>
            </tr>
            @foreach($items as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </main>
@endsection