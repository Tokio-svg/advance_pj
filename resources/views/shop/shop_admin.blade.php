@extends('layouts.layout_admin')

@section('title','飲食店管理画面')

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
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <h2 class="content_title">店舗情報</h2>
      <div class="shop_info-flex">
        <img class="shop_image" src="{{$shop->image_url}}" alt="no_image" style="margin-right: 40px;">
        <table class="shop_info">
          <tr>
            <th>名前</th>
            <td>{{$shop->name}}</td>
          </tr>
          <tr>
            <th>地域</th>
            <td>{{$shop->area->name}}</td>
          </tr>
          <tr>
            <th>ジャンル</th>
            <td>{{$shop->genre->name}}</td>
          </tr>
          <tr>
            <th>紹介文</th>
            <td>{{$shop->overview}}</td>
          </tr>
          <tr>
            <th>営業時間</th>
            <td>
              <p>{{substr($schedule->opening_time,0,5)}} ~ {{substr($schedule->closing_time,0,5)}}</p>
              <table>
                <tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>
                <tr style="text-align: center;">
                  <?php
                    for($i=0; $i<7; $i++) {
                      echo "<td>" . put_schedule_mark($shop->schedule->day_of_week[$i]) . "</td>";
                    }
                  ?>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
      <!-- お気に入り、評価情報 -->
      <div class="shop_info-flex">
        <div style="margin-right: 20px;">
          お気に入り登録者数：{{$favorites}}
        </div>
        <div>
          評価平均：{{$average}}
          評価数：{{$evaluation_count}}
        </div>
      </div>
      <div style="margin: 30px auto; text-align: center;" class="button_search">
        <a href="{{ route('shop.change') }}" style="color: white; display: block;">登録情報を変更する</a>
      </div>
    </div>
  </main>
@endsection

@section('script')
<!-- PHP関数：引数が0なら"×"、それ以外なら"○"を返す -->
  <?php
    function put_schedule_mark($day) {
      if ($day === 0) {
        return '×';
      } else {
        return '○';
      }
    }
  ?>
  <script>
    // 関数：削除の確認ダイアログを表示
    function confirmDelete() {
      if (!window.confirm("本当に削除してもよろしいですか？")) {
        return false;
      }
    }
  </script>
@endsection