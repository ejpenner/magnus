
@foreach($permissionFields as $key => $value)
    <div class="col-lg-3 permission-box">
        <input type="checkbox" id="{{ $value }}" name="{{ $value }}"
               @if($permissions['attributes'][$value])
               checked
               @endif
               class="checkbox-vis-hidden" value=1>
        <label for="{{ $value }}">{{ ucwords(preg_replace( "/_/", " ", $value)) }}</label>
    </div>

@endforeach