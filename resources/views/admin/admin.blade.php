@extends('adminlte::page')

@section('title', 'Admins')


@section('content')

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $admin)
        <tr>
            <td>{{$admin->id}}</td>
            <td>{{$admin->username}}</td>
            <td>{{$admin->password}}</td>
            <td>{{$admin->nombre}}</td>
            <td>{{$admin->apellido}}</td>
            <td>{{$admin->email}}</td>
            <td><img src="{{$admin->foto}}" width="50" height="50"></td
        </tr>
        @endforeach
    </tbody>
</table>    
@endsection
