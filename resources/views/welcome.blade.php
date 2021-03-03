@extends('layouts')

@section('content')

    @if (Auth::check())
    {{ Auth::user->name }}
    @else
        <div class="center jumbortron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary]') !!}
            </div>
        </div>
    @endif
@endsection