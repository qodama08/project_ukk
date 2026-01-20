@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Roles</th>
            <td>
                @foreach ($user->roles as $role)
                    {{ $role->nama_role }}<br>
                @endforeach
            </td>
        </tr>
    </table>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection