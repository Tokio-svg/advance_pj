@extends('layouts.layout_admin')

@section('title','飲食店新規作成画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    @component('components.sidebar_admin')
    @endcomponent
    <div class="content_wrap">
    </div>
  </main>
@endsection

@section('script')
  <script>
  </script>
@endsection