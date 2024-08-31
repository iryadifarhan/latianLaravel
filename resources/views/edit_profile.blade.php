@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto pt-3">
            <div class="card">
                <div class="card-header">
                    Profile Page
                </div>
                <div class="card-body">
                    <form action="{{route('changeProfile')}}" method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label" for="name">Nama:</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}">
                        </div>
                        <div class="mb-2">
                            <p class="form-label">Email:</p>
                            <input type="text" class="form-control" value="{{$user->email}}" disabled readonly>
                        </div>
                        <div class="mb-2">
                            <p class="form-label">Role:</p>
                            <input type="text" class="form-control" value="{{($user->is_admin == 0) ? 'Member' : 'Admin'}}" disabled readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password_change">Password</label>
                            <input class="form-control w-100" type="password" name="password" id="password_change" placeholder="Ketik password baru mu">
                        </div>
                        <div class="mb-2">
                            <label class="form-label"for="password_conf">Konfirmasi Password</label>
                            <input class="form-control w-100" type="password" name="password_confirmation" id="password_conf" placeholder="Ketik password kembali">
                        </div>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @endif
                        <button class="btn btn-primary mt-3 w-25" type="submit">Ganti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection