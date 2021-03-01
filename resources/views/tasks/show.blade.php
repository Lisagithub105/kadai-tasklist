@extends('layouts.app')

@section('content')

    <h1>タスク詳細ページ</h1>
    <table class="table table-border">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>状況</th>
            <td>{{ $task->status }}</td>
        </tr>
        <tr>
            <th>タスク名</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
    {{-- タスク名編集ページへリンク --}}
    {!! link_to_route('tasks.edit', 'このタスク名を編集', ['task' => $task->id], ['class' => 'btn btn-light']) !!}
    
    {{-- タスク削除フォーム --}}
    {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method'=>'delete']) !!}
    {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    
    
@endsection