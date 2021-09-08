@extends('layouts.layout')

@section('title','管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    <div class="sidebar">
      <p style="margin-top: 100px;">サイドメニュー</p>
    </div>
    <div class="content_wrap">
      <div class="serch_wrap">
        検索フォーム
      </div>
      <div class="result_wrap">
        検索結果
        <table>
          <tr>
            <th>ID</th>
            <th>name</th>
            <th>email</th>
            <th>created_at</th>
          </tr>
          @foreach($users as $user)
            <tr>
              <td>{{$user->id}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->created_at}}</td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </main>
@endsection