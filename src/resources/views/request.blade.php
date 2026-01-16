@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="request-list">

    <h2>勤怠修正申請一覧</h2>

    {{-- タブ --}}
    <div class="tabs">
        <a href="{{ route('request.index', ['tab' => 'pending']) }}"
           class="{{ $tab === 'pending' ? 'active' : '' }}">
            承認待ち
        </a>
        <a href="{{ route('request.index', ['tab' => 'approved']) }}"
           class="{{ $tab === 'approved' ? 'active' : '' }}">
            承認済み
        </a>
    </div>
    
    <table>
            <tr>    
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>

            @if ($approvals->count() > 0)
            @foreach ($approvals as $approval)
            <tr>
                {{-- ステータス --}}
                <td>
                    {{ $approval->status === 'pending' ? '承認待ち' : '承認済み' }}
                </td>

                {{-- 名前 --}}
                <td>
                    {{ $approval->attendance?->user?->name ?? '-' }}

                {{-- 対象日 --}}
                <td>
                    {{ $approval->attendance?->start_time?->format('Y/m/d') ?? '-' }}
                </td>

                {{-- 申請理由 --}}
                <td>
                    {{ $approval->remarks }}
                </td>

                {{-- 申請日時 --}}
                <td>
                    {{ $approval->created_at->format('Y/m/d H:i') }}
                </td>

                {{-- 詳細 --}}
                <td>
                    <a href="{{ route('attendancedetail.detail', ['id' => $approval->attendance_id]) }}">
                        詳細
                    </a>
                </td>
            </tr>
        @endforeach
        @else
            <tr>
                <td>申請はありません</td>
            </tr>
        @endif
        </tbody>
    </table>

</div>
@endsection