@extends('layouts.layout')

@section('title','店舗管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="sidebar">
      <p style="margin-top: 100px;">サイドメニュー</p>
      <div class="sidebar_button shadow" style="background: rgb(115, 125, 153);">
        <a href="{{ route('admin.user') }}">
          <div class="sidebar_button-content">
            <img src="{{putSource('/img/person.png')}}" alt="no image">
            <p>ユーザー管理</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow" style="background: rgb(53, 96, 246);">
        <a href="{{ route('admin.shop') }}">
          <div class="sidebar_button-content">
            <p>店舗管理</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow" style="background: rgb(53, 96, 246);">
        <a href="{{ route('shop.register') }}">
          <div class="sidebar_button-content">
            <p>店舗アカウント作成</p>
          </div>
        </a>
      </div>
      <div class="sidebar_button shadow" style="background: rgb(115, 125, 153);">
        <a href="#" onclick="event.preventDefault(); document.getElementById('admin_logout-form').submit();">
          <div class="sidebar_button-content">
            <p>ログアウト</p>
          </div>
        </a>
        <form id="admin_logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </div>

    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <p style="margin-top: 100px;">検索フォーム</p>
          <form action="{{ route('admin.shop') }}" method="get">
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
            <a href="{{ route('admin.shop') }}">クリア</a>
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
              <th>店名</th>
              <th>地域</th>
              <th>ジャンル</th>
              <th>登録日時</th>
              <th></th>
            </tr>
            @foreach($items as $shop)
              <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->name}}</td>
                <td>{{$shop->area->name}}</td>
                <td>{{$shop->genre->name}}</td>
                <td>{{$shop->created_at}}</td>
                <td>
                  <form action="{{ route('admin.shop.delete') }}" method="post" onsubmit="return confirmDelete()">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                    <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
                    <button type="submit">削除</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('script')
  <script>
    // 関数：削除の確認ダイアログを表示
    function confirmDelete() {
      if (!window.confirm("本当に削除してもよろしいですか？")) {
        return false;
      }
    }

  </script>
@endsection