@extends('layouts.layout')

@section('title','会員登録ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="card_title">Registration</h1>
  <div class="form_wrap">
    <form method="POST" action="/register">
      @csrf
      <!-- ユーザーネーム -->
      <div>
        <img src="{{putSource('/img/person.png')}}" alt="no image">
        <input id="name" type="text" name="name" value="{{old('name')}}" placeholder="Username" onblur="validateRequire(this.id,'error_name-require')" required />
        @error('name')
        <p class="error">{{$message}}</p>
        @enderror
        <p id="error_name-require" class="error" style="display: none;">名前を入力してください</p>
      </div>
      <!-- メールアドレス -->
      <div>
        <img src="{{putSource('/img/mail.png')}}" alt="no image">
        <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" onblur="validateRequire(this.id,'error_email-require'); validateEmail()" required />
        @error('email')
        <p class="error">{{$message}}</p>
        @enderror
        <p id="error_email-require" class="error" style="display: none;">メールアドレスを入力してください</p>
        <p id="error_email-type" class="error" style="display: none;">メールアドレスの形式で入力してください</p>
      </div>
      <!-- パスワード -->
      <div>
        <img src="{{putSource('/img/key.png')}}" alt="no image">
        <input id="password" type="password" name="password" placeholder="Password" onblur="validatePasswordMin()" required />
        @error('password')
        <p class="error">{{$message}}</p>
        @enderror
        <p id="error_password-min" class="error" style="display: none;">パスワードは8文字以上で入力してください</p>
      </div>
      <button type="submit">登録</button>
    </form>
  </div>
</main>
@endsection

@section('script')
<script>
  // 関数：入力必須バリデーション
  function validateRequire(id, errorId) {
    const errorMessage = document.getElementById(errorId);
    // // 該当のエラーメッセージ要素が存在しない場合は終了
    // if (!errorMessage) {
    //   return;
    // }
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
    // // 該当のエラーメッセージ要素が存在しない場合は終了
    // if (!errorMessage) {
    //   return;
    // }
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
    // // 該当のエラーメッセージ要素が存在しない場合は終了
    // if (!errorMessage) {
    //   return;
    // }
    const input = document.getElementById('password');
    if (input.value.length < 8) {
      errorMessage.style.display = "block";
    } else {
      errorMessage.style.display = "none";
    }
  }
</script>
@endsection