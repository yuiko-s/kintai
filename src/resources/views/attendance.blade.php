@extends('layouts.workapp')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')

        <div class="attendance-form__content">
            <div class="attendance-form__status">
                @switch($status)
                    @case(0)
                        <p>出勤中</p>
                        @break

                    @case(1)
                        <p>休憩中</p>
                        @break

                     @case(3)
                        <p>退勤済</p>
                        @break   

                    @default
                        <p>出勤外</p>
                @endswitch
            </div>    

            <div class="attendance-form__heading">
                <p>{{ $today }}</p>
            </div>

            <div class='attendance-form__time'>
                <h2>{{ $totime }}</h2>
            </div>
            
            <div class="attendance-form__button">
                @switch($status)
                    @case(0)
                    <form action="{{ route('attendances.clockout') }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="clockout_button">退勤</button>
                    </form>
                    <form action="{{ route('breaktime.breakin') }}" method="POST" style="display:inline-block; margin-left:8px;">
                        @csrf
                        <button type="submit" class="breakin_button">休憩入</button>
                    </form>
                    @break

                    @case(1)
                    <form action="{{ route('breaktime.breakout') }}" method="POST">
                        @csrf
                        <button type="submit" class="breakout_button">休憩戻</button>
                    </form>
                    @break

                    @case(3)
                        <p>お疲れさまでした。</p>
                    @break

                    @default
                    <form action="{{ route('attendances.clockin') }}" method="POST">
                        @csrf
                        <button type="submit" class="clockin_button">出勤</button>
                    </form>
                @endswitch
            </div>
        </div>
@endsection
