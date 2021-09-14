@extends('layouts.layout_admin')

@section('title','予約情報管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <p style="margin-top: 100px;">検索フォーム</p>
          <form action="{{ route('shop.reservation') }}" method="get">
            <!-- ユーザーネーム -->
            <div>
              <label for="name">ユーザーネーム</label>
              <input type="text" name="name" id="name" value="{{$inputs['name']}}">
              <!-- メールアドレス -->
              <label for="email">メールアドレス</label>
              <input type="text" name="email" id="email" value="{{$inputs['email']}}">
            </div>
            <!-- 予約日 -->
            <div>
              <label for="date_start">予約日</label>
              <input type="date" name="date_start" id="date_start" value="{{$inputs['date_start']}}">~
              <input type="date" name="date_end" id="date_end" value="{{$inputs['date_end']}}">
            </div>
            <!-- 予約時間 -->
            <div>
              <label for="time_start">予約時間</label>
              <input type="time" name="time_start" id="time_start" value="{{$inputs['time_start']}}">~
              <input type="time" name="time_end" id="time_end" value="{{$inputs['time_end']}}">
            </div>
            <!-- 人数 -->
            <div>
              <label for="number_start">人数</label>
              <input type="number" name="number_start" id="number_start" value="{{$inputs['number_start']}}">~
              <input type="number" name="number_end" id="number_end" value="{{$inputs['number_end']}}">
            </div>
            <!-- 登録日 -->
            <div>
              <label for="create_start">登録日</label>
              <input type="date" name="create_start" id="create_start" value="{{$inputs['create_start']}}">~
              <input type="date" name="create_end" id="create_end" value="{{$inputs['create_end']}}">
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
              <th>予約日</th>
              <th>予約時間</th>
              <th>人数</th>
              <th>登録日時</th>
            </tr>
            @foreach($items as $reservation)
              <tr>
                <td>{{$reservation->user->name}}</td>
                <td>{{$reservation->user->email}}</td>
                <td>{{$reservation->date}}</td>
                <td>{{$reservation->time}}</td>
                <td>{{$reservation->number}}名様</td>
                <td>{{$reservation->created_at}}</td>
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