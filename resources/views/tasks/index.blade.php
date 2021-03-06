@extends('layouts.app')

@section('content')

<?php 
//dd($tasks);
?>
    <h1>タスク一覧</h1>
    
    @if (Auth::check())
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>状況</th>
                        <th>タスク名</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        {{-- メッセージ詳細ページへのリンク --}}
                        <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->content }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            {{-- タスク作成ページへのリンク --}}
            {!! link_to_route('tasks.create', '新規タスク名の投稿', [], ['class' => 'btn btn-primary']) !!}
    
    @else
        まだログインしていません。
    @endif
@endsection