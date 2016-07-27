@include('journal._entry', ['journal' => $journal, 'user' => $user])
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