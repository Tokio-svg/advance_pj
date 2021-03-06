@extends('layouts.layout_admin')

@section('title','評価情報管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
  <style>
    .sidebar_button:nth-of-type(4) {
      background: rgb(0, 36, 145);
    }
    td {
      max-width: 300px;
    }
  </style>
@endsection

@section('content')
  <main>
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <div class="search_wrap">
        <div class="search_content">
          <h2 class="content_title">検索フォーム</h2>
          <form action="{{ route('shop.evaluation') }}" method="get">
            <div>
              <!-- ユーザーネーム -->
              <label for="name">ユーザーネーム</label>
              <input type="text" name="name" id="name" value="{{$inputs['name']}}">
              <!-- メールアドレス -->
              <label for="email">メールアドレス</label>
              <input type="text" name="email" id="email" value="{{$inputs['email']}}">
            </div>
            <!-- 評価 -->
            <div>
              <label for="grade_start">評価</label>
              <select name="grade_start" id="grade_start">
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                  <!-- 入力値と同じ項目を初期値に設定 -->
                  @if ($i == $inputs['grade_start'])
                    <option value="{{$i}}" selected>{{$i}}</option>
                  @else
                    <option value="{{$i}}">{{$i}}</option>
                  @endif
                @endfor
              </select>~
              <select name="grade_end" id="grade_end">
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                  <!-- 入力値と同じ項目を初期値に設定 -->
                  @if ($i == $inputs['grade_end'])
                    <option value="{{$i}}" selected>{{$i}}</option>
                  @else
                    <option value="{{$i}}">{{$i}}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div>
              <!-- コメント -->
              <label for="name">コメント</label>
              <input type="text" name="comment" id="comment" value="{{$inputs['comment']}}">
            </div>
            <!-- 登録日 -->
            <div>
              <label for="date_start">登録日</label>
              <input type="date" name="date_start" id="date_start" value="{{$inputs['date_start']}}">~
              <input type="date" name="date_end" id="date_end" value="{{$inputs['date_end']}}">
            </div>
            <!-- 検索ボタン -->
            <div style="text-align: center;">
              <button class="button_search" type="submit">検索</button>
            </div>
          </form>
          <!-- 検索条件クリア -->
          <div style="text-align: center;">
            <a href="{{ route('shop.evaluation') }}">クリア</a>
          </div>
        </div>
      </div>
      <div class="result_wrap">
        <div class="result_content">
          <h2 class="content_title">検索結果</h2>
          {{$items->appends(request()->query())->links('vendor.pagination.default_custom')}}
          <table class="result_table">
            <tr>
              <th>お客様名</th>
              <th>お客様メールアドレス</th>
              <th>評価</th>
              <th>コメント</th>
              <th>登録日時</th>
            </tr>
            @foreach($items as $evaluation)
              <tr>
                <td>{{$evaluation->user->name}}</td>
                <td>{{$evaluation->user->email}}</td>
                <td>{{$evaluation->grade}}</td>
                <td>
                  <p id="comment_{{$evaluation->id}}" onmouseover="exchangeText(this.id)" onmouseout="exchangeText(this.id)">
                    <?php
                    if (mb_strlen($evaluation->comment) >= 25) {
                      $short = mb_substr($evaluation->comment, 0, 25);
                      echo $short . '...';
                    } else {
                      echo $evaluation->comment;
                    }
                    ?>
                  </p>
                  <div style="display: none;">{{$evaluation->comment}}</div>
                </td>
                <td>{{$evaluation->created_at}}</td>
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

    // 関数：引数のidを持つ要素と次の要素のtextContentを入れ替える
    function exchangeText(id) {
      const element = document.getElementById(id);
      const tmp = element.textContent;
      const nextElement = element.nextElementSibling;

      element.textContent = nextElement.textContent;
      nextElement.textContent = tmp;
    }
  </script>
@endsection