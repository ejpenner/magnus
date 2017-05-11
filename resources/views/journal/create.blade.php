@extends('layouts.app')

@section('content')
    <div class="col-lg-6">
        {!! Form::open(['action' => 'JournalController@store']) !!}
            @include('journal._form')
        {!! Form::close() !!}
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Journals
            </div>
            <div class="panel-body">
                @if($journals->count() > 0)
                    <ul class="list-group">
                        @foreach($journals as $journal)
                            <li class="list-group-item">
                                {{ $journal->title }}
                                <span class="pull-right">
                                    <a class="btn btn-xs btn-info" href="{{ action('JournalController@edit', ['journal' => $journal->slug]) }}">Edit</a>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    No journals yet
                @endif
            </div>
        </div>
    </div>
@endsection