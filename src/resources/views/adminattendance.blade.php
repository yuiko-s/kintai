@extends('layouts.adminapp')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')

<p>勤怠詳細</p>


<form action="{{ route('adminattendance.update', ['id' => $attendance->id]) }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $attendance->id }}">                
         <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">名前</span>
            </div>
            <div class="text">
                    <p>{{ $attendance->user?->name ?? '-' }}</p>
            </div>
            <div class="form__group-title">
                <span class="form__label--item">日付</span>
            </div>
            <div class="form__group-content">
                <div class="text">
                    <p>{{ $attendance?->start_time?->format('Y年') ?? '-' }}</p>
                </div>
                <div class="text">
                    <p>{{ $attendance?->start_time?->format('m月d日') ?? '-' }}</p>
                </div>
                    {{-- <div class="form__group-content"> 
                         <div class="form__input--text"> 
                            <input type="text" name="start_time" value="{{$attendance?->start_time?->format('m月d日') ?? '-'}}"/>
                        </div> --}}
                <div class="form__group-title">
                    <span class="form__label--item">出勤・退勤</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="start_time" value="{{$attendance?->start_time?->format('H:i') ?? ''}}"/>
                    </div>
                         
                    <div class="form__input--text">
                        <input type="text" name="end_time" value="{{$attendance?->end_time?->format('H:i') ?? ''}}"/>
                    </div>
                    <div class="form__group-title">
                        <span class="form__label--item">休憩</span>
                    </div>
                    <div class="form__group-content">
                         @foreach($breakTimes as $breakTime)
                        <div class="form__input--text">
                            <input type="text" name="break_start[]" value="{{ $breakTime->break_start?->format('H:i') ?? '' }}">
                        </div>
                        <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="break_end[]" value="{{ $breakTime->break_end?->format('H:i') ?? '' }}">
                        </div>
                        @endforeach
                        
                    <div class="form__group-title">
                        <span class="form__label--item">備考</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="remarks"/>
                        </div>
                    <div class="form__button">
                    <button class="form__button-submit" type="submit">修正</button>
                </div>
</form>


@endsection
