@extends('layouts.app')

@section('content')

    <h1>タスク一覧</h1>
    
    @if (count($tasks) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>タスク名</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->content }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    
    {{-- タスク作成ページへのリンク --}}
    {!! link_to_route('tasks.create', '新規タスク名の投稿', [], ['class' => 'btn btn-primary']) !!}

@endsection