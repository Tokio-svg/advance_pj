@extends('layouts.layout_admin')

@section('title','飲食店管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
  <style>
    .sidebar_button:nth-of-type(2) {
      background: rgb(0, 36, 145);
    }
    input[type="radio"] {
      width: 20px;
    }
  </style>
@endsection

@section('content')
  <main>
    @component('components.sidebar_admin')
    @endcomponent
    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <h2 class="content_title">検索フォーム</h2>
          <form action="{{ route('admin.shop') }}" method="get">
            <!-- 飲食店名 -->
            <label for="name">店名</label>
            <input type="text" name="name" id="name" value="{{$inputs['name']}}">
            <!-- 地域 -->
            <label for="area">地域</label>
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
            <label for="genre">ジャンル</label>
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
            <div>
              <!-- 登録日 -->
              <label for="date_start">登録日</label>
              <input type="date" name="date_start" id="date_start" value="{{$inputs['date_start']}}">~
              <input type="date" name="date_end" id="date_end" value="{{$inputs['date_end']}}">
              <!-- 公開情報 -->
              公開状態：
              <label for="public_all">指定しない</label>
              <input type="radio" name="public" id="public_all" value="" checked>
              <label for="public_true">公開</label>
              <input type="radio" name="public" id="public_true" value="1">
              <label for="public_false">非公開</label>
              <input type="radio" name="public" id="public_false" value="2">
            </div>
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div style="text-align: center;">
            <a href="{{ route('admin.shop') }}">クリア</a>
          </div>
        </div>
      </div>
      <div class="result_wrap">
        <div class="result_content">
          <h2 class="content_title">検索結果</h2>
          {{$items->appends(request()->query())->links('vendor.pagination.default_custom')}}
          <table class="result_table">
            <tr>
              <th>ID</th>
              <th>店名</th>
              <th>地域</th>
              <th>ジャンル</th>
              <th>登録日</th>
              <th>公開</th>
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
                  @if(!$shop->public)
                    ×
                  @else
                    ○
                  @endif
                </td>
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