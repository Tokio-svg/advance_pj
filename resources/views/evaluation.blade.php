@extends('layouts.layout')

@section('title','評価投稿ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/evaluation_style.css')}}">
@endsection

@section('content')
<main>
  <div class="info_title" style="display: flex;">
    <a href="/detail/{{$shop->id}}" class="back shadow">＜</a>
    <h1 class="shop_name">{{$shop->name}}</h1>
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
<div class="evaluation_wrap shadow">
  <div class="evaluation_content" style="padding: 40px 30px;">
    <h1>このお店の評価を入力してください</h1>
    <form action="/evaluation" method="post">
      @csrf
      <h2>投稿者名</h2>
      <div>
        <?php
          // 初期値を設定
          if (old('nickname')) {
            $nickname = old('nickname');
          } elseif ($evaluation) {
            $nickname = $evaluation->nickname;
          } else {
            $nickname = '';
          }
        ?>
        <input type="text" name="nickname" id="nickname" placeholder="未入力の場合はユーザー名が表示されます" value="{{$nickname}}">
      </div>
      <h2>評価(5段階)</h2>
      @if($evaluation)
        <input type="hidden" name="evaluation_id" value="{{$evaluation->id}}">
      @else
        <input type="hidden" name="evaluation_id" value="">
      @endif
      <input type="hidden" name="user_id" value="{{$user->id}}">
      <input type="hidden" name="shop_id" value="{{$shop->id}}">
      <input type="hidden" name="url" value="/detail/{{$shop->id}}">
      <div class="grade_wrap">
        <?php
        // 初期値を設定
        if (old('grade')) {
          $grade = old('grade');
        } elseif ($evaluation) {
          $grade = $evaluation->grade;
        } else {
          $grade = 3;
        }
        ?>
        <div class="range_wrap">
          <div class="range_scale">
            <p>1</p>
            <p>2</p>
            <p>3</p>
            <p>4</p>
            <p>5</p>
          </div>
          <input type="range" name="grade" id="grade" min="1" max="5" step="1" value="{{$grade}}" onchange="changeGrade(this.value)" onblur="validateRequire(this.id, 'error_grade-require');">
          <p id="error_grade-require" class="error" style="display: none;">評価を選択してください</p>
          <p id="error_grade-between" class="error" style="display: none;">正しい値を選択してください</p>
        </div>
      </div>
      <div class="comment_wrap">
        <h2>コメント</h2>
        <?php
        // 初期値を設定
        if (old('comment')) {
          $comment = old('comment');
        } elseif ($evaluation) {
          $comment = $evaluation->comment;
        } else {
          $comment = '';
        }
        ?>
        <textarea name="comment" id="comment" onchange="changeComment(this.value)" onblur="validateRequire(this.id, 'error_comment-require');" oninput="validateMax(this.id)" required>{{$comment}}</textarea>
        <p id="error_comment-require" class="error" style="display: none;">コメントを入力してください</p>
        <p id="error_comment-max" class="error" style="display: none;">コメントは120文字以内で入力してください</p>
      </div>
      <div class="evaluation_confirm">
        <table>
          <tr>
            <th>評価</th>
            <td><img src="{{putSource('/img/star_' . $grade . '.png')}}" alt="no_image" id="grade_confirm"></td>
          </tr>
          <tr>
            <th>コメント</th>
            <td id="comment_confirm">{{$comment}}</td>
          </tr>
        </table>
      </div>
  </div>
  <div class="submit">
    <button type="submit">送信</button>
  </div>
  </form>
</div>
@endsection

@section('script')
<script>
  // 読み込み時の処理
  window.onload = function() {
    // ★laravelエラーメッセージの有無を取得して
    // 対応するエラーメッセージを表示状態に変更する
    let errors = {
      grade: [],
      comment: [],
    };
    // 1.$errorから全エラーメッセージを取得する
    <?php
    if ($errors->has('grade')) {
      $tmp = $errors->get('grade');
      foreach ($tmp as $error) {
        echo "errors.grade.push('{$error}');";
      }
    }
    if ($errors->has('comment')) {
      $tmp = $errors->get('comment');
      foreach ($tmp as $error) {
        echo "errors.comment.push('{$error}');";
      }
    }
    ?>
    // 2.各エラーメッセージごとに表示するかどうかチェックする
    errors.grade.forEach((e) => {
      if (e === '評価を選択してください') {
        document.getElementById('error_grade-require').style.display = "block";
      }
      if (e === '正しい値を選択してください') {
        document.getElementById('error_grade-between').style.display = "block";
      }
    });
    errors.comment.forEach((e) => {
      if (e === 'コメントを入力してください') {
        document.getElementById('error_comment-require').style.display = "block";
      }
      if (e === 'コメントは120文字以内で入力してください') {
        document.getElementById('error_comment-max').style.display = "block";
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

  // 関数：ご意見の入力値に変化があったら文字数をカウントして120文字を超えていたらエラーメッセージを表示する
  function validateMax(id) {
    const errorMessage = document.getElementById('error_comment-max');
    // 該当のエラーメッセージ要素が存在しない場合は終了
    const input = document.getElementById(id);
    if (input.value.length > 120) {
      errorMessage.style.display = "block";
    } else {
      errorMessage.style.display = "none";
    }
  }

  // 関数：name=gradeの値を対応するimgのsrcに反映する
  function changeGrade(value) {
    const grade = document.getElementById('grade_confirm');
    grade.src = "/img/star_" + value + ".png";
  }

  // 関数：name=commentの値を対応するタグに反映する
  function changeComment(value) {
    document.getElementById('comment_confirm').textContent = value;
  }
</script>
@endsection