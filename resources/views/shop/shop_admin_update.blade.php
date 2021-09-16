@extends('layouts.layout_admin')

@section('title','飲食店管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
  <style>
    .dayOfWeek {
      width: 50px;
    }
  </style>
@endsection

@section('content')
  <main>
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <p style="margin-top: 100px;">店舗登録情報変更</p>
      <form action="{{ route('shop.update') }}" method="post">
        @csrf
        <div class="shop_info-flex">
          <div class="shop_info-imagewrap">
            <img id="shop_image" class="shop_image" src="{{$shop->image_url}}" alt="no_image">
            <div>
            <label for="image_url">画像URL</label>
              <input type="text" name="image_url" id="image_url" value="{{$shop->image_url}}" onblur="validateRequire(this.id,'error_image_url-require'); changeImage(this.id)" required>
              <p id="error_image_url-require" class="error" style="display: none;">画像URLを入力してください</p>
            </div>
          </div>
          <div class="shop_input-wrap">
            <div>
              <label for="name">名前</label>
              <input type="text" name="name" id="name" value="{{$shop->name}}" onblur="validateRequire(this.id,'error_name-require')" required>
              <p id="error_name-require" class="error" style="display: none;">名前を入力してください</p>
            </div>
            <div>
              <label for="area_id">地域</label>
              <select name="area_id" id="area_id" onblur="validateRequire(this.id,'error_area-require')" required>
                @foreach($areas as $area)
                  @if($area->id == $shop->area->id)
                    <option value="{{$area->id}}" selected>{{$area->name}}</option>
                  @else
                    <option value="{{$area->id}}">{{$area->name}}</option>
                  @endif
                @endforeach
              </select>
              <p id="error_area-require" class="error" style="display: none;">地域を選択してください</p>
            </div>
            <div>
              <label for="genre_id">ジャンル</label>
              <select name="genre_id" id="genre_id" onblur="validateRequire(this.id,'error_genre-require')" required>
                @foreach($genres as $genre)
                  @if($genre->id == $shop->genre->id)
                    <option value="{{$genre->id}}" selected>{{$genre->name}}</option>
                  @else
                    <option value="{{$genre->id}}">{{$genre->name}}</option>
                  @endif
                @endforeach
              </select>
              <p id="error_genre-require" class="error" style="display: none;">ジャンルを選択してください</p>
            </div>
            <div>
              <label for="overview">紹介文</label>
              <textarea name="overview" id="overview" onblur="validateRequire(this.id,'error_overview-require')" required>{{$shop->overview}}</textarea>
              <p id="error_overview-require" class="error" style="display: none;">紹介文を入力してください</p>
            </div>
            <div>
              営業時間
              <label for="opening_time">開店</label>
              <select name="opening_time" id="opening_time" onblur="validateRequire(this.id,'error_opening_time-require')" required>
                <?php
                  $time = substr($schedule->opening_time, 0, 5);
                  for($i=0; $i<24; $i++) {
                    if ( $time === substr("0" . $i . ":00",-5)) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                    echo "<option value='" . $i . ":00'" . $selected . ">" . $i . ":00</option>";
                    if ($time === substr("0" . $i . ":30",-5)) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                    echo "<option value='" . $i . ":30'" . $selected . ">" . $i . ":30</option>";
                  }
                ?>
              </select>~
              <p id="error_opening_time-require" class="error" style="display: none;">開店時間を選択してください</p>
              <div>
                <label for="closing_time">閉店</label>
                <select name="closing_time" id="closing_time" onblur="validateRequire(this.id,'error_closing_time-require')" required>
                  <?php
                    $time = substr($schedule->closing_time, 0, 5);
                    for($i=0; $i<24; $i++) {
                      if ( $time === substr("0" . $i . ":00",-5)) {
                        $selected = 'selected';
                      } else {
                        $selected = '';
                      }
                      echo "<option value='" . $i . ":00'" . $selected . ">" . $i . ":00</option>";
                      if ($time === substr("0" . $i . ":30",-5)) {
                        $selected = 'selected';
                      } else {
                        $selected = '';
                      }
                      echo "<option value='" . $i . ":30'" . $selected . ">" . $i . ":30</option>";
                      }
                  ?>
                </select>
                <p id="error_closing_time-require" class="error" style="display: none;">閉店時間を選択してください</p>
              </div>
            </div>
            <div>
              営業日
              <table>
                <tr>
                  <th>日</th>
                  <th>月</th>
                  <th>火</th>
                  <th>水</th>
                  <th>木</th>
                  <th>金</th>
                  <th>土</th>
                </tr>
                <tr>
                  <td>
                    @if($schedule->day_of_week[0] == 0)
                      <input type="checkbox" name="sun" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="sun" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[1] == 0)
                      <input type="checkbox" name="mon" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="mon" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[2] == 0)
                      <input type="checkbox" name="tue" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="tue" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[3] == 0)
                      <input type="checkbox" name="wed" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="wed" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[4] == 0)
                      <input type="checkbox" name="thu" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="thu" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[5] == 0)
                      <input type="checkbox" name="fri" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="fri" class="dayOfWeek" checked>
                    @endif
                  </td>
                  <td>
                    @if($schedule->day_of_week[6] == 0)
                      <input type="checkbox" name="sat" class="dayOfWeek">
                    @else
                      <input type="checkbox" name="sat" class="dayOfWeek" checked>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
            <div>
              @if($shop->public == 0)
                <label for="public">公開</label>
                <input type="radio" name="public" id="public" value="1">
                <label for="not_public">非公開</label>
                <input type="radio" name="public" id="not_public" value="0" checked>
              @else
                <label for="public">公開</label>
                <input type="radio" name="public" id="public" value="1" checked>
                <label for="not_public">非公開</label>
                <input type="radio" name="public" id="not_public" value="0">
              @endif
            </div>
          </div>
        </div>
        <button type="submit">変更</button>
      </form>
      <div>
        <a href="{{ route('shop.top')}} ">戻る</a>
      </div>
    </div>
  </main>
@endsection

@section('script')
  <script>
    // 読み込み時にlaravelエラーメッセージの有無を取得して
    // 対応するエラーメッセージを表示状態に変更する
    window.onload = function() {
      let errors = {
        image_url: [],
        name: [],
        area: [],
        genre: [],
        overview: [],
        opening_time: [],
        closing_time: [],
        public: [],
      };
      // 1.$errorから全エラーメッセージを取得する
      <?php
      if ($errors->has('image_url')) {
        $tmp = $errors->first('image_url');
        echo "errors.image_url.push('{$tmp}');";
      }
      if ($errors->has('name')) {
        $tmp = $errors->first('name');
        echo "errors.name.push('{$tmp}');";
      }
      if ($errors->has('area_id')) {
        $tmp = $errors->first('area_id');
        echo "errors.area_id.push('{$tmp}');";
      }
      if ($errors->has('genre_id')) {
        $tmp = $errors->first('genre_id');
        echo "errors.genre_id.push('{$tmp}');";
      }
      if ($errors->has('overview')) {
        $tmp = $errors->first('overview');
        echo "errors.overview.push('{$tmp}');";
      }
      if ($errors->has('opening_time')) {
        $tmp = $errors->first('opening_time');
        echo "errors.opening_time.push('{$tmp}');";
      }
      if ($errors->has('closing_time')) {
        $tmp = $errors->first('closing_time');
        echo "errors.closing_time.push('{$tmp}');";
      }

      ?>
      // 2.各エラーメッセージごとに表示するかどうかチェックする
      if (errors.image_url[0]) {
        document.getElementById('error_image_url-require').style.display = "block";
      }
      if (errors.name[0]) {
        document.getElementById('error_name-require').style.display = "block";
      }
      if (errors.area[0]) {
        document.getElementById('error_area-require').style.display = "block";
      }
      if (errors.genre[0]) {
        document.getElementById('error_genre-require').style.display = "block";
      }
      if (errors.overview[0]) {
        document.getElementById('error_overview-require').style.display = "block";
      }
      if (errors.opening_time[0]) {
        document.getElementById('error_opening_time-require').style.display = "block";
      }
      if (errors.closing_time[0]) {
        document.getElementById('error_closing_time-require').style.display = "block";
      }
    }

    // 関数：引数に渡されたIDのvalueをimageのsrcに設定する
    function changeImage(id) {
      const src = document.getElementById(id).value;
      const image = document.getElementById('shop_image');
      image.src = src;
    }

    // 関数：入力必須バリデーション
    function validateRequire(id, errorId) {
      const errorMessage = document.getElementById(errorId);
      const input = document.getElementById(id).value;
      if (!input) {
        errorMessage.style.display = "block";
      } else {
        errorMessage.style.display = "none";
      }
    }
  </script>
@endsection