@extends('layouts.adminapp')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')

    <div class="attendancelist-form__content">
        <div class="attendancelist-form__heading">
                <h2>{{ $user->name }}さんの勤怠</h2>
        </div>

        <tr>
                <a href="{{ route('adminattendancestaff.index',['user' => $user->id,'month' => $today->copy()->subMonth()->format('Y-m')]) }}">←</a>
                <td>{{$today->copy()->subMonth()->format('Y/m');}}</td>
                <td>{{$today->format('Y/m');}}</td>
                <td>{{$today->copy()->addMonth()->format('Y/m');}}</td>
                <a href="{{ route('adminattendancestaff.index', ['user' => $user->id,'month' => $today->copy()->addMonth()->format('Y-m')]) }}">→</a>

            </tr>
        <table>
            <tr>    
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
                
                @foreach($days as $day)
                @php
                    $key = $day->toDateString();
                    $attendance = $attendanceByDate[$key] ?? null;
                    $breakMinutes = $breakMinutesByDate[$key] ?? 0;
                    $workMinutes = $workMinutesByDate[$key] ?? 0;
                @endphp
                <tr> 
                    <td>{{$day ->isoformat('MM/DD(ddd)')}}</td>
               
                    <td>{{$attendance?->start_time?->format('H:i') ?? '-'}}</td>

                    <td>{{$attendance?->end_time?->format('H:i') ?? '-'}}</td>

                    <td>{{$breakMinutes
                        ? sprintf('%02d:%02d', intdiv($breakMinutes, 60), $breakMinutes % 60)
                        : '-' }}</td>

                    <td>{{ $workMinutes
                        ? sprintf('%02d:%02d', intdiv($workMinutes,60), $workMinutes%60)
                        : '-' }}</td>


                    <td>
                         @if($attendance) 
                            <a href="{{ route('adminattendancestaff.index', ['user' => $user->id]) }}">詳細</a>
                         @else 
                             <a href="{{ route('adminstafflist.index') }}">詳細</a> 
                         @endif 
                    </td>


                </tr>
                @endforeach
                
        </table>
        <div class="form__button">
            <button class="form__button-submit" type="submit">CSV出力</button>
        </div>
    </div>
@endsection