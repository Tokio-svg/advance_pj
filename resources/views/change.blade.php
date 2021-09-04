@extends('layouts.layout')

@section('title','予約情報変更ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/change_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="change_title">予約情報変更</h1>
  <div class="change_content">
    <div class="reservation_info">
      <div class="reservation_card shadow">
        <div class="reservation_flex">
          <div>
            <img src="{{putSource('/img/clock.png')}}" alt="no image" style="width: 28px;">
          </div>
          <p>予約状況</p>
        </div>
        <div class="reservation_flex">
          <table class="reservation_table">
            <tr>
              <th>Shop</th>
              <td>{{$reservation->shop->name}}</td>
            </tr>
            <tr>
              <th>Date</th>
              <td>{{$reservation->date}}</td>
            </tr>
            <tr>
              <th>Time</th>
              <td>
                <?php
                $time = substr($reservation->time, 0, 5);
                echo $time;
                ?>
              </td>
            </tr>
            <tr>
              <th>Number</th>
              <td>{{$reservation->number}}人</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="reservation_wrap shadow">
      <div class="reservation_content">
        <h1>予約変更</h1>
        <form action="/reserve/{{$reservation->id}}" method="post">
          @csrf
          @if (Auth::check())
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
          @endif
          <input type="hidden" name="shop_id" value="{{$reservation->shop->id}}">
          <input type="hidden" name="url" value="/mypage">
          <div>
            <!-- 当日の1日後～30日後までを選択可能にする（暫定） -->
            <input type="date" name="date" id="date" min="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))); ?>" max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 30, date("Y"))); ?>" onblur="validateRequire(this.id,'error_date-require')" onchange="changeDate(this.value)" value="{{$reservation->date}}" required>
            <p id="error_date-require" class="error" style="display: none;">日付を選択してください</p>
          </div>
          <div>
            <select name="time" id="time" onblur="validateRequire(this.id,'error_time-require')" onchange="changeTime(this.value)" required>
              <option value="">時間を選択してください</option>
              <?php
              for ($i = 10; $i <= 19; $i++) {
                echo "<option value='" . $i . ":00'>" . $i . ":00</option>";
                echo "<option value='" . $i . ":30'>" . $i . ":30</option>";
              }
              ?>
            </select>
            <p id="error_time-require" class="error" style="display: none;">時間を選択してください</p>
          </div>
          <div>
            <select name="number" id="number" onblur="validateRequire(this.id,'error_number-require')" onchange="changeNumber(this.value)" required>
              <option value="">人数を選択してください</option>
              <?php
              for ($i = 1; $i < 11; $i++) {
                if ($reservation->number == $i) {
                  echo "<option value='" . $i . "' selected>" . $i . "人</option>";
                } else {
                  echo "<option value='" . $i . "'>" . $i . "人</option>";
                }
              }
              ?>
            </select>
            <p id="error_number-require" class="error" style="display: none;">人数を選択してください</p>
          </div>
          <div class="reservation_confirm">
            <h2>変更後</h2>
            <table class="table_reservation">
              <tr>
                <th>Shop</th>
                <td>{{$reservation->shop->name}}</td>
              </tr>
              <tr>
                <th>Date</th>
                <td><span id="date_display">{{$reservation->date}}</span></td>
              </tr>
              <tr>
                <th>Time</th>
                <td><span id="time_display">{{substr($reservation->time, 0, 5)}}</span></td>
              </tr>
              <tr>
                <th>Number</th>
                <td><span id="number_display">
                    {{$reservation->number}}人
                  </span></td>
              </tr>
            </table>
          </div>
      </div>
      <div class="submit">
        <button type="submit">変更する</button>
      </div>
      </form>
    </div>
  </div>
</main>
@endsection

@section('script')
<script>
  // 読み込み時の処理
  window.onload = function() {
    // ★laravelエラーメッセージの有無を取得して
    // 対応するエラーメッセージを表示状態に変更する
    let errors = {
      date: [],
      time: [],
      number: [],
    };
    // 1.$errorから全エラーメッセージを取得する
    <?php
    if ($errors->has('date')) {
      $tmp = $errors->first('date');
      echo "errors.date.push('{$tmp}');";
    }
    if ($errors->has('time')) {
      $tmp = $errors->first('time');
      echo "errors.time.push('{$tmp}');";
    }
    if ($errors->has('number')) {
      $tmp = $errors->first('number');
      echo "errors.number.push('{$tmp}');";
    }

    ?>
    // 2.各エラーメッセージごとに表示するかどうかチェックする
    if (errors.date[0]) {
      document.getElementById('error_date-require').style.display = "block";
    }
    if (errors.time[0]) {
      document.getElementById('error_time-require').style.display = "block";
    }
    if (errors.number[0]) {
      document.getElementById('error_number-require').style.display = "block";
    }

    // ★timeフォームの初期値をoldから設定する
    let oldTime = '';
    // oldの値を取得する
    <?php
    echo "oldTime = '" . old('time') . "';";
    echo "oldTime = '" . $reservation->time . "';";
    ?>
    oldTime = oldTime.substr(0, 5);
    if (!oldTime) {
      return;
    }
    // oldTimeと一致するvalueを持つoptionタグを選択状態にする
    const time = document.getElementById('time').options;
    Object.keys(time).forEach((key) => {
      if (time[key].value === oldTime) {
        time[key].selected = true;
      }
    });
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

  // 関数：name=dateの値を対応するタグに反映する
  function changeDate(value) {
    document.getElementById('date_display').textContent = value;
  }
  // 関数：name=timeの値を対応するタグに反映する
  function changeTime(value) {
    document.getElementById('time_display').textContent = value;
  }
  // 関数：name=numberの値を対応するタグに反映する
  function changeNumber(value) {
    document.getElementById('number_display').textContent = value + '人';
  }
</script>
@endsection