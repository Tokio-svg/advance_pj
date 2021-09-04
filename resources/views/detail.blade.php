@extends('layouts.layout')

@section('title','飲食店詳細ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/detail_style.css')}}">
@endsection

@section('content')
<main>
  <div class="info_title" style="display: flex;">
    <a href="/" class="back shadow">＜</a>
    <h1 class="shop_name">{{$shop->name}}</h1>
    <p>{{substr($shop->schedule->opening_time,0,5)}} ~ {{substr($shop->schedule->closing_time,0,5)}}</p>
  </div>
  <div class="image">
    <img src="{{$shop->image_url}}" alt="no image">
  </div>
  <div class="tag">
    <a href="/?area_id={{$shop->area_id}}">#{{$shop->area->name}}</a>
    <a href="/?genre_id={{$shop->genre_id}}">#{{$shop->genre->name}}</a>
  </div>
  <p>{{$shop->overview}}</p>
</main>
@endsection

@section('reservation')
<div class="reservation_wrap shadow">
  <div class="reservation_content">
    <h1>予約</h1>
    <form action="/reserve" method="post">
      @csrf
      @if (Auth::check())
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
      @endif
      <input type="hidden" name="shop_id" value="{{$shop->id}}">
      <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
      <div>
        <!-- 当日の1日後～30日後までを選択可能にする（暫定） -->
        <input type="date" name="date" id="date" min="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))); ?>" max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 30, date("Y"))); ?>" onblur="validateRequire(this.id,'error_date-require')" onchange="changeDate(this.value)" value="{{old('date')}}" required>
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
            if (old('number') == $i) {
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
        <table class="table_reservation">
          <tr>
            <th>Shop</th>
            <td>{{$shop->name}}</td>
          </tr>
          <tr>
            <th>Date</th>
            <td><span id="date_display">{{old('date')}}</span></td>
          </tr>
          <tr>
            <th>Time</th>
            <td><span id="time_display">{{old('time')}}</span></td>
          </tr>
          <tr>
            <th>Number</th>
            <td><span id="number_display">
                @if (old('number'))
                  {{old('number')}}人
                @endif
              </span></td>
          </tr>
        </table>
      </div>
  </div>
  <div class="submit">
    @if (Auth::check())
      <button type="submit">予約する</button>
    @else
      <p>予約をご希望の方は<a href="/login" style="color: white; text-decoration: underline;">ログイン</a>してください</p>
    @endif
  </div>
  </form>
</div>
@endsection

@section('evaluation')
<div class="evaluation_wrap">
  <div class="evaluation_flex">
    <div class="evaluation_grade-wrap">
      <div class="evaluation_grade shadow">
        <h1>評価(全{{$grades[0]}}件)</h1>
        @if ($grades[0] === 0)
          <p>評価はまだありません</p>
        @else
        <table class="grade_table">
          <tr>
            <th style="width: 30px;">平均</th>
            <td>
              <img src="{{putSource('/img/star_' . round($grades[6]) . '.png')}}" alt="no image">
              <p>({{round($grades[6],2)}})</p>
            </td>
          </tr>
          <?php
          if ($grades[0] != 0) {
            for ($i = 1; $i < 6; $i++) {
              echo "<tr>
                          <th>$i</th>
                          <td><div class='grade_rate'>" . round($grades[$i] / $grades[0] * 100) . "</div></td>
                          <td>$grades[$i](" . round($grades[$i] / $grades[0] * 100) . "%)</td>
                        </tr>";
            }
          } else {
            for ($i = 1; $i < 6; $i++) {
              echo "<tr>
                            <th>$i</th>
                            <td>$grades[$i](0%)</td>
                          </tr>";
            }
          }
          ?>
        </table>
        @endif
      </div>
      @if (Auth::check())
        <a href="/evaluation/{{$shop->id}}" class="evaluation_button shadow">評価を投稿する</a>
      @endif
    </div>
    <div class="evaluation_comment shadow">
      <h1>最新の評価</h1>
      @if ($grades[0] === 0)
        <p>評価はまだありません</p>
      @endif
      @foreach($comments as $comment)
        <div class="comment_content">
          <div style="display: flex; justify-content: space-between;">
            <p>{{$comment->user->name}}さん</p>
            <p>
              {{$comment->created_at}}
              @if($comment->created_at < $comment->updated_at)
                ({{$comment->updated_at}}更新)
                @endif
            </p>
          </div>
          <p style="margin: 10px 0;">
            <img src="{{putSource('/img/star_' . $comment->grade . '.png')}}" alt="{{$comment->grade}}">
          </p>
          <p>{{$comment->comment}}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>
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

    // ★評価の割合ゲージのパラメータを設定する
    let rateItems = document.getElementsByClassName('grade_rate');
    for (let i = 0; i < rateItems.length; i++) {
      const rate = rateItems[i].textContent;
      rateItems[i].textContent = "";
      rateItems[i].style.background = "linear-gradient(to right,yellow " + rate + "%,rgb(85, 128, 247) " + rate + "%)";
    }

    // ★timeフォームの初期値をoldから設定する
    let oldTime = '';
    // oldの値を取得する
    <?php
    echo "oldTime = '" . old('time') . "';";
    ?>
    if (!oldTime) {
      return;
    }
    // oldTimeと一致するvalueを持つoptionタグを選択状態にする
    const time = document.getElementById('time').options;
    Object.keys(time).forEach((key) => {
      if (time[key].value === oldTime) {
        time[key].selected = true;
        return;
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