<div class="journal-entry panel panel-default">
    <div class="panel-body">
        <div class="journal-title">
            <a href="{{ action('JournalController@show', [$user->slug, $journal->slug]) }}"><h3>{{ $journal->title }}</h3></a>
        </div>
        <div class="journal-details">
            by <a href="{{ action('ProfileController@show', $user->slug) }}">{{ $user->username }}</a>,
            {{ $journal->created_at }}
        </div>
        <hr>
        <div class="journal-body">
            <p>{{ $journal->parsedBody }}</p>
        </div>
    </div>
</div>