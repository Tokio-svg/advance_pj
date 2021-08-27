<p>{{$user->name}}さん</p>
<p>本日{{$reservations->count()}}件の予約情報が登録されています</p>
@foreach($reservations as $item)
  <br>
  <p>Shop : {{$item->shop->name}}</p>
  <p>Date : {{$item->date}}</p>
  <p>Time : {{$item->time}}</p>
  <p>Number : {{$item->number}}人</p>
@endforeach