@foreach($paginatedResults as $result)
    @include('search.partials._result', ['opus' => $result])
@endforeach