@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table ">
            <thead>
            <tr>
                <th>Session Dump</th>
            </tr>
            </thead>
            <tbody>
            @foreach($session as $sKey => $sValue)
                <tr class="col-md-12">
                    @if(gettype($sValue) == "array")
                        <td class="col-md-3">{{ $sKey }} => </td>
                        @foreach($sValue as $key => $value)

                            @if(gettype($value) == 'array')
                                    <td class="col-md-3">{{ $key }} => </td>
                                @foreach($value as $subKey => $subValue)
                                    <td class="col-md-1">{{ $subKey }} => {{ $subValue }}</td>
                                @endforeach
                            @else
                                <td>{{ $key }} => {{ $value }}</td>
                            @endif
                        @endforeach
                    @else
                        <td class="col-md-3">{{ $sKey }} => {{ $sValue }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection