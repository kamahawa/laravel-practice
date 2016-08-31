@extends('admin.master')
@section('controller', 'User')
@section('action', 'Add')

@section('content')
<div class="col-lg-7" style="padding-bottom:120px">
    @include('admin.blocks.error')
    <form action="" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="form-group">
            <label>Username</label>
            <input class="form-control" name="txtUser" value="{!! old('txtUser') !!}" placeholder="Please Enter Username" />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="txtPass" value="{!! old('txtPass') !!}" placeholder="Please Enter Password" />
        </div>
        <div class="form-group">
            <label>RePassword</label>
            <input type="password" class="form-control" name="txtRePass" value="{!! old('txtRePass') !!}" placeholder="Please Enter RePassword" />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="txtEmail" value="{!! old('txtEmail') !!}" placeholder="Please Enter Email" />
        </div>
        <div class="form-group">
            <label>User Level</label>
            <label class="radio-inline">
                <input name="rdoLevel" value="1" checked="" type="radio">Admin
            </label>
            <label class="radio-inline">
                <input name="rdoLevel" value="2" type="radio">Mod
            </label>
            <label class="radio-inline">
                <input name="rdoLevel" value="3" type="radio">Member
            </label>
        </div>
        <button type="submit" class="btn btn-default">User Add</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </form>
</div>
@endsection
