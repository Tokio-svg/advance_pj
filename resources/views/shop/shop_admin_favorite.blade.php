@extends('layouts.layout_admin')

@section('title','お気に入り情報管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <div style="margin-top: 100px;">
        <p>お気に入り登録者数：{{$items->count()}}</p>
      </div>
      <div class="search_wrap">
        <div class="search_content">
          <p>検索フォーム</p>
          <form action="{{ route('shop.reservation') }}" method="get">
            <!-- ユーザーネーム -->
            <div>
              <label for="name">ユーザーネーム</label>
              <input type="text" name="name" id="name" value="">
            </div>
            <!-- メールアドレス -->
            <div>
              <label for="email">メールアドレス</label>
              <input type="text" name="email" id="email" value="">
            </div>
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div>
            <a href="{{ route('shop.reservation') }}">クリア</a>
          </div>
        </div>
      </div>
      <div class="result_wrap">
        <div class="result_content">
          検索結果
          {{$items->appends(request()->query())->links('vendor.pagination.default_custom')}}
          <table class="result_table">
            <tr>
              <th>お客様名</th>
              <th>お客様メールアドレス</th>
              <th>登録日時</th>
            </tr>
            @foreach($items as $favorite)
              <tr>
                <td>{{$favorite->user->name}}</td>
                <td>{{$favorite->user->email}}</td>
                <td>{{$favorite->created_at}}</td>
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