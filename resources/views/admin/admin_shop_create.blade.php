@extends('layouts.layout_admin')

@section('title','飲食店新規作成画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    @component('components.sidebar_admin')
    @endcomponent
    <div class="content_wrap" style="margin-top: 100px;">
      <form action="{{ route('admin.shop.create') }}" method="post">
        @csrf
        <div>
          <label for="name">名前</label>
          <input type="text" name="name" id="name" value="新規飲食店">
        </div>
        <button type="submit">作成</button>
      </form>
    </div>
  </main>
@endsection

@section('script')
  <script>
  </script>
@endsection