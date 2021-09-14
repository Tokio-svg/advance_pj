@extends('layouts.layout_admin')

@section('title','管理者ログインページ')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
  <style>
    .card_title {
      background: rgb(246, 53, 53);
    }
  </style>
@endsection

@section('content')
  <main class="shadow">
    <h1 class="card_title">Login</h1>
    <div class="form_wrap">
      <p id="error_auth" class="error" style="display: none;">メールアドレスまたはパスワードが違います</p>
      <form method="POST" action="/admin/login">
        @csrf
        <!-- メールアドレス -->
        <div>
          <img src="{{putSource('/img/mail.png')}}" alt="no image">
          <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" onblur="validateRequire(this.id,'error_email-require')" required />
          <p id="error_email-require" class="error" style="display: none;">メールアドレスを入力してください</p>
        </div>
        <!-- パスワード -->
        <div>
          <img src="{{putSource('/img/key.png')}}" alt="no image">
          <input id="password" type="password" name="password" placeholder="Password" onblur="validateRequire(this.id,'error_password-require')" required />
          <p id="error_password-require" class="error" style="display: none;">パスワードを入力してください</p>
        </div>
        <!-- 管理者認証キー -->
        <div>
          <img src="{{putSource('/img/key.png')}}" alt="no image">
          <input id="password" type="password" name="key" placeholder="Admin key" onblur="validateRequire(this.id,'error_key-require')" required />
          <p id="error_key-require" class="error" style="display: none;">管理者認証キーを入力してください</p>
        </div>
        <div class="auth_button">
          <button type="submit">ログイン</button>
          <!-- Remember Me -->
          <div class="remember_wrap">
            <label for="remember_me">
                <input id="remember_me" type="checkbox"  name="remember">
                <span>ログイン状態を維持する</span>
            </label>
          </div>
        </div>
      </form>
    </div>
    <div>
      <a href="{{ route('admin.register') }}">新規登録</a>
    </div>
  </main>
@endsection

@section('script')
  <script>
    // 読み込み時にlaravelエラーメッセージの有無を取得して
    // 対応するエラーメッセージを表示状態に変更する
    window.onload = function() {
      let errors = {
        email: [],
        password: [],
      };
      // 1.$errorから全エラーメッセージを取得する
      <?php
      if ($errors->has('email')) {
        $tmp = $errors->first('email');
        echo "errors.email.push('{$tmp}');";
      }
      if ($errors->has('password')) {
        $tmp = $errors->get('password');
        foreach ($tmp as $error) {
          echo "errors.password.push('{$error}');";
        }
      }

      ?>
      // 2.各エラーメッセージごとに表示するかどうかチェックする
      if (errors.email[0]) {
        document.getElementById('error_email-require').style.display = "block";
      }
      errors.password.forEach((e) => {
        if (e === 'パスワードを入力してください') {
          document.getElementById('error_password-require').style.display = "block";
        }
        if (e === 'メールアドレスまたはパスワードが違います') {
          document.getElementById('error_auth').style.display = "block";
        }
      })

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