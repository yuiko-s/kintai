@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="adminstafflist-form__content">
  <div class="adminstafflist-form__heading">
    <h2>スタッフ一覧画面</h2>
  </div>

  <table>
    <tr>
      <th>名前</th>
      <th>メールアドレス</th>
      <th>月次勤怠</th>
    </tr>
    @foreach ($users as $user)
    <tr>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>
        <a href="{{ route('adminattendancestaff.index', ['id' => $user->id]) }}">詳細</a>
      </td>
    </tr>
    @endforeach
@endsection
</table>