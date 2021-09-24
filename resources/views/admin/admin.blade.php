@extends('layouts.layout_admin')

@section('title','ユーザー管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
  <style>
    .sidebar_button:nth-of-type(1) {
      background: rgb(0, 36, 145);
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
          <form action="{{ route('admin.user') }}" method="get">
            <!-- ユーザーネーム -->
            <div>
              <label for="name">ユーザーネーム</label>
              <input type="text" name="name" id="name" value="{{$inputs['name']}}">
              <!-- メールアドレス -->
              <label for="email">メールアドレス</label>
              <input type="text" name="email" id="email" value="{{$inputs['email']}}">
            </div>
            <!-- 登録日 -->
            <div>
              <label for="date_start">登録日</label>
              <input type="date" name="date_start" id="date_start" value="{{$inputs['date_start']}}">~
              <input type="date" name="date_end" id="date_end" value="{{$inputs['date_end']}}">
            </div>
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div style="text-align: center;">
            <a href="{{ route('admin.user') }}">クリア</a>
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
              <th>名前</th>
              <th>メールアドレス</th>
              <th>登録日</th>
              <th></th>
            </tr>
            @foreach($items as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                  <form action="{{ route('admin.user.delete') }}" method="post" onsubmit="return confirmDelete()">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
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