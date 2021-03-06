@extends('layouts.layout')

@section('title','会員登録ページ')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
@endsection

@section('content')
  <main class="shadow">
    <h1 class="card_title">登録情報変更</h1>
    <div class="form_wrap">
      <form method="POST" action="{{ route('mypage.update') }}">
        @csrf
        <!-- ユーザーネーム -->
        <div>
          <img src="{{putSource('/img/person.png')}}" alt="no image">
          <!-- 初期値を設定 -->
          <?php
            if (old('name')) {
              $value = old('name');
            } else {
              $value = $user->name;
            }
          ?>
          <input id="name" type="text" name="name" value="{{$value}}" placeholder="Username" onblur="validateRequire(this.id,'error_name-require')" required />
          <p id="error_name-require" class="error" style="display: none;">名前を入力してください</p>
        </div>
        <!-- メールアドレス -->
        <div>
          <img src="{{putSource('/img/mail.png')}}" alt="no image">
          <!-- 初期値を設定 -->
          <?php
            if (old('email')) {
              $value = old('email');
            } else {
              $value = $user->email;
            }
          ?>
          <input id="email" type="email" name="email" value="{{$value}}" placeholder="Email" onblur="validateRequire(this.id,'error_email-require'); validateEmail()" required />
          <p id="error_email-require" class="error" style="display: none;">メールアドレスを入力してください</p>
          <p id="error_email-type" class="error" style="display: none;">メールアドレスの形式で入力してください</p>
          <p id="error_email-unique" class="error" style="display: none;">そのメールアドレスは既に使用されています</p>
        </div>
      <!-- パスワード -->
      <div>
        <img src="{{putSource('/img/key.png')}}" alt="no image">
        <input id="password" type="password" name="password" placeholder="Password" onblur="validatePasswordMin()" required />
        <p id="error_password-min" class="error" style="display: none;">パスワードは8文字以上で入力してください</p>
      </div>
        <div class="auth_button">
          <button type="submit">変更</button>
        </div>
      </form>
    </div>
  </main>
  <!-- ユーザー削除ボタン -->
  <div class="delete_wrap">
    <a href="{{ route('mypage.top') }}" style="font-size: 14px;">戻る</a>
    <form action="{{ route('mypage.delete') }}" method="post" onsubmit="return confirmDelete()">
      @csrf
      <button type="submit">退会する</button>
    </form>
  </div>
@endsection

@section('script')
  <script>
    // 読み込み時にlaravelエラーメッセージの有無を取得して
    // 対応するエラーメッセージを表示状態に変更する
    window.onload = function() {
      let errors = {
        name: [],
        email: [],
        password: [],
      };
      // 1.$errorから全エラーメッセージを取得する
      <?php
      if ($errors->has('name')) {
        $tmp = $errors->first('name');
        echo "errors.name.push('{$tmp}');";
      }
      if ($errors->has('email')) {
        $tmp = $errors->get('email');
        foreach ($tmp as $error) {
          echo "errors.email.push('{$error}');";
        }
      }
      if ($errors->has('password')) {
        $tmp = $errors->first('password');
        echo "errors.password.push('{$tmp}');";
      }
      ?>
      // 2.各エラーメッセージごとに表示するかどうかチェックする
      if (errors.name[0]) {
        document.getElementById('error_name-require').style.display = "block";
      }
      errors.email.forEach((e) => {
        if (e === 'メールアドレスを入力してください') {
          document.getElementById('error_email-require').style.display = "block";
        }
        if (e === 'メールアドレスの形式で入力してください') {
          document.getElementById('error_email-type').style.display = "block";
        }
        if (e === 'そのメールアドレスは既に使用されています') {
          document.getElementById('error_email-unique').style.display = "block";
        }
      });
      if (errors.password[0]) {
        document.getElementById('error_password-min').style.display = "block";
      }
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

    // 関数：メールアドレス形式バリデーション
    // 1文字以上 @ 1文字以上 . 1文字以上の形の文字列をメールアドレス形式とする
    function validateEmail() {
      const errorMessage = document.getElementById('error_email-type');
      const input = document.getElementById("email").value;
      // 未入力の場合はエラーメッセージを非表示にして終了
      if (!input) {
        errorMessage.style.display = "none"
        return;
      }
      // メールアドレス形式かどうかチェックして表示を切り替え
      if (!input.match(/.+@.+\..+/)) {
        errorMessage.style.display = "block";
      } else {
        errorMessage.style.display = "none";
      }
    }

    // 関数：パスワード8文字以上バリデーション
    function validatePasswordMin() {
      const errorMessage = document.getElementById('error_password-min');
      const input = document.getElementById('password');
      if (input.value.length < 8) {
        errorMessage.style.display = "block";
      } else {
        errorMessage.style.display = "none";
      }
    }

    // 関数：削除の確認ダイアログを表示
    function confirmDelete() {
      if (!window.confirm("本当に退会してもよろしいですか？")) {
        return false;
      }
    }

  </script>
@endsection