@extends('layouts.layout')

@section('title','ログインページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
@endsection

@section('content')
<main class="shadow">
  <h1 class="card_title">Login</h1>
  <div class="form_wrap">
    <form method="POST" action="/login">
      @csrf
      <!-- メールアドレス -->
      <div>
        <img src="{{putSource('/img/mail.png')}}" alt="no image">
        <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" onblur="validateRequire(this.id,'error_email-require')" required />
        @error('email')
        <p class="error">{{$message}}</p>
        @enderror
        <p id="error_email-require" class="error" style="display: none;">メールアドレスを入力してください</p>
      </div>
      <!-- パスワード -->
      <div>
        <img src="{{putSource('/img/key.png')}}" alt="no image">
        <input id="password" type="password" name="password" placeholder="Password" onblur="validateRequire(this.id,'error_password-require')" required />
        @error('password')
        <p class="error">{{$message}}</p>
        @enderror
        <p id="error_password-require" class="error" style="display: none;">パスワードを入力してください</p>
      </div>
      <button type="submit">ログイン</button>
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
</script>
@endsection