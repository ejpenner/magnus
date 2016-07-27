@extends('layouts.app')

@section('content')
    @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>false])
    <div class="container">
        @include('journal._entry', ['journal' => $journal, 'user' => $user])
    </div>
    @include('comment._commentsJournal', ['journal' => $journal, 'comments' => $journal->comments])
@endsection