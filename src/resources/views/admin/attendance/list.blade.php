@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="adminattendancelist-form__content">
  <div class="adminattendancelist-form__heading">
    <h2>勤怠一覧</h2>
  </div>

  
  <div class="adminattendancelist-date-nav">
    <a href="{{ route('adminattendancelist.index', ['day' => $today->copy()->subDay()->format('Y-m-d')]) }}">←</a>
    <span>{{ $today->format('Y/m/d') }}</span>
    <a href="{{ route('adminattendancelist.index', ['day' => $today->copy()->addDay()->format('Y-m-d')]) }}">→</a>
  </div>

  <table>
      <tr>
        <th>名前</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>合計</th>
        <th>詳細</th>
      </tr>

      @foreach($attendances as $attendance)
        @php
          $key = $attendance->id;
          $breakMinutes = $breakMinutesByAttendanceId[$key] ?? 0;
          $workMinutes  = $workMinutesByAttendanceId[$key] ?? 0;
        @endphp

        <tr>
          <td>{{ $attendance->user?->name ?? '-' }}</td>
          <td>{{ $attendance?->start_time?->format('H:i') ?? '-' }}</td>
          <td>{{ $attendance?->end_time?->format('H:i') ?? '-' }}</td>

          <td>
            {{ $breakMinutes
                ? sprintf('%02d:%02d', intdiv($breakMinutes,60), $breakMinutes%60)
                : '-' }}
          </td>

          <td>
            {{ $workMinutes
                ? sprintf('%02d:%02d', intdiv($workMinutes,60), $workMinutes%60)
                : '-' }}
          </td>

          <td>
            <a href="{{ route('attendancedetail.detail', ['id' => $attendance->id]) }}">詳細</a>
          </td>
        </tr>
      @endforeach
   
  </table>
</div>
@endsection
