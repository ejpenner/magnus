<div class="col-lg-6">
    {!! Form::model($journal, ['method' => 'PATCH', 'action' => ['JournalController@update', $journal->slug]]) !!}
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
                                    <a class="btn btn-xs btn-info" href="">Edit</a>
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