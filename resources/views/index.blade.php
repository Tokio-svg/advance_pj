<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>飲食店一覧ページ</title>
  <!-- スタイルシート読み込み -->
  @if(app('env')=='local')
  <link rel="stylesheet" href="{{asset('/css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('/css/index_style.css')}}">
  @else
  <link rel="stylesheet" href="{{secure_asset('/css/reset.css')}}">
  <link rel="stylesheet" href="{{secure_asset('/css/index_style.css')}}">
  @endif
</head>

<body>
  <header>
    <h1>ろご</h1>
  </header>
  <main>
    @foreach ($items as $item)
    <div class="card_wrap">
      <p>{{$item->image_url}}</p>
      <p>{{$item->name}}</p>
      <p>{{$item->area->name}}</p>
      <p>{{$item->genre->name}}</p>
      <p>詳しく見る</p>
      <p>♥</p>
    </div>
    @endforeach
  </main>
</body>

</html>