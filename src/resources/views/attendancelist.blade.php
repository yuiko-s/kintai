@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')

    <div class="attendancelist-form__content">
        <div class="attendancelist-form__heading">
                <h2>勤怠一覧</h2>
        </div>

        <tr>
                <a href="{{ route('attendancelist.index', ['month' => $today->copy()->subMonth()->format('Y-m')]) }}">←</a>
                <td>{{$today->copy()->subMonth()->format('Y/m');}}</td>
                <td>{{$today->format('Y/m');}}</td>
                <td>{{$today->copy()->addMonth()->format('Y/m');}}</td>
                <a href="{{ route('attendancelist.index', ['month' => $today->copy()->addMonth()->format('Y-m')]) }}">→</a>

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
            <tr>
                
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
                            <a href="{{ route('attendancedetail.detail', ['id' => $attendance->id]) }}">詳細</a>
                         @else 
                             <a href="{{ route('attendancedetail.create') }}">詳細</a> 
                         @endif 
                    </td>


                </tr>
                @endforeach

                
                    
            </tr>
        </table>

    </div>
@endsection