@extends('layouts.app')

@section('content')
    @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>false])
    <div class="col-lg-6 col-lg-offset-3">
        <div class="text-center" style="margin-bottom: 10px;">
            <a class="btn btn-primary btn-lg" href="{{ action('JournalController@create') }}"><i class="fa fa-plus"></i> New Journal Entry</a>
        </div>
        @foreach($journals as $journal)
            @include('journal._entry', ['journal' => $journal, 'user'=>$user])
            <div class="journal-stats">
                <div class="clearfix">
                    <a class="pull-left" href="{{ action('JournalController@show', [$user->slug, $journal->slug]) }}">{{ $journal->title }}</a>
                    <div class="pull-right journal-date">
                        {{ $journal->created_at }}
                    </div>
                </div>

                <div>
                    <i class="fa fa-comment"></i>
                    @if($journal->comments->count() == 0)
                        No Comments
                    @elseif($journal->comments->count() == 1)
                        1 Comment
                    @else
                        {{ $journal->comments->count() }} Comments
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection