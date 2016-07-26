@extends('layouts.app')

@section('content')
    @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>false])
    <div class="container">
        @foreach($journals as $journal)
        @endforeach
    </div>
@endsection