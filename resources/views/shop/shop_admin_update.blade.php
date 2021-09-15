@extends('layouts.layout_admin')

@section('title','飲食店管理画面')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/admin_style.css')}}">
@endsection

@section('content')
  <main>
    @component('components.sidebar_shop')
    @endcomponent
    <div class="content_wrap">
      <p style="margin-top: 100px;">店舗登録情報変更</p>
      <form action="{{ route('shop.update') }}" method="post">
        @csrf
        <div class="shop_info-flex">
          <div class="shop_info-imagewrap">
            <img class="shop_image" src="{{$shop->image_url}}" alt="no_image">
            <div>
            <label for="image_url">画像URL</label>
              <input type="text" name="image_url" id="image_url" value="{{$shop->image_url}}">
            </div>
          </div>
          <div class="shop_input-wrap">
            <div>
              <label for="name">名前</label>
              <input type="text" name="name" id="name" value="{{$shop->name}}">
            </div>
            <div>
              <label for="area_id">地域</label>
              <select name="area_id" id="area_id">
                @foreach($areas as $area)
                  @if($area->id == $shop->area->id)
                    <option value="{{$area->id}}" selected>{{$area->name}}</option>
                  @else
                    <option value="{{$area->id}}">{{$area->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div>
              <label for="genre_id">ジャンル</label>
              <select name="genre_id" id="genre_id">
                @foreach($genres as $genre)
                  @if($genre->id == $shop->genre->id)
                    <option value="{{$genre->id}}" selected>{{$genre->name}}</option>
                  @else
                    <option value="{{$genre->id}}">{{$genre->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div>
              <label for="overview">紹介文</label>
              <textarea name="overview" id="overview">{{$shop->overview}}</textarea>
            </div>
            <div>
              営業時間
            </div>
            <div>
              営業日
            </div>
            <div>
              @if($shop->public == 0)
                <label for="public">公開</label>
                <input type="radio" name="public" id="public" value="1">
                <label for="not_public">非公開</label>
                <input type="radio" name="public" id="not_public" value="0" checked>
              @else
                <label for="public">公開</label>
                <input type="radio" name="public" id="public" value="1" checked>
                <label for="not_public">非公開</label>
                <input type="radio" name="public" id="not_public" value="0">
              @endif
            </div>
          </div>
        </div>
        <button type="submit">変更</button>
      </form>
      <div>
        <a href="{{ route('shop.top')}} ">戻る</a>
      </div>
    </div>
  </main>
@endsection

@section('script')
  <script>
  </script>
@endsection