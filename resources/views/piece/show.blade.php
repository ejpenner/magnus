@extends('layouts.app')

@section('content')
    <div class="col-md-2">
        @unless($piece->tags->isEmpty())
            <h5>Tags:</h5>
            <div>
                <ul class="list-inline">
                    @foreach($piece->tags as $tag)
                        <li>{{ $tag->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endunless
    </div>
    <div class="col-md-8">
        <div class="piece-display">
            <img class="piece-show" src="/{{ $piece->getImage() }}" alt="">
            <h2>{{ $piece->title }}</h2>

            <div class="well">
                @if(Auth::check() and (Auth::user()->isOwner($piece) or Auth::user()->hasRole('admin')))
                    <div class="pull-right">
                        {!! Form::model($piece, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                               'action'=>['PieceController@destroy', $gallery->id, $piece->id]]) !!}
                        <a href="{{ action('PieceController@edit', [$gallery->id, $piece->id]) }}">
                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                        </a>
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                        {!! Form::close() !!}
                    </div>
                @endif
                <p>{{ $piece->comment }}</p>
            </div>
        </div>
    </div>
@endsection