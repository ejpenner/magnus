@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Permission Editor</h3>
        <div class="container">@include('permission._createModal')</div>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Schema Name</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $i => $permission)
                    <tr>
                        <td>{{ $permission->schema_name }}</td>
                        <td>
                            {{--@include('partials._operations', ['model'=>$permission, 'controller' => 'PermissionController'])--}}
                            @include('permission._editModal', ['id'=>$i, 'model'=>$permission])
                            {!! Form::model($permission, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['PermissionController@destroy', $permission->id]]) !!}
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop