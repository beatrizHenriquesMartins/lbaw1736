@extends('layouts.main', ['type' => $type])
@section('content')
<form method="post" action="{{ route('editprofile', ['id'=> $user -> id]) }}" enctype="multipart/form-data">
   {{csrf_field()}}
    <input type="text" name="firstname"  value="{{ $user->firstname }}" />
    <input type="text" name="lastname"  value="{{ $user->lastname }}" />
    <input type="text" name="username"  value="{{ $user->username }}" />
    <input type="email" name="email"  value="{{ $user->email }}" />
    <input type="password" name="password" />
    <input type="password" name="password_confirmation" />
    <input type="number" name="nif"  value="{{ $user->nif }}" />
    <button type="submit">Save</button>
</form>
@endsection