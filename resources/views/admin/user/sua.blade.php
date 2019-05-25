@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>{{$user->name}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                    {{$err}}<br>
                    @endforeach
                </div>
                @endif

                @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>

                @endif
                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" name="name" placeholder="Please Enter Full Name" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input readonly type="email" class="form-control" name="email" placeholder="Please Enter Email" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="changePassword" id="check-changePass">
                        <label>Change Password</label>
                        <input disabled type="password" class="form-control un-diss-pass" name="password" placeholder="Please Enter Password" />
                    </div>
                    <div class="form-group">
                        <label>Re-Password</label>
                        <input disabled type="password" class="form-control un-diss-pass" name="passwordAgain" placeholder="Please Enter Again Password" />
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <label class="radio-inline">
                            <input name="level" value="0" @if($user->level == 0) {{"checked"}} @endif type="radio">Member
                        </label>
                        <label class="radio-inline">
                            <input name="level" value="1" @if($user->level == 1) {{"checked"}} @endif type="radio">Admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#check-changePass").change(function() {
            if ($(this).is(":checked")) {
                $(".un-diss-pass").removeAttr('disabled');
            } else {
                $(".un-diss-pass").attr('disabled', '');
            }
        });
    });
</script>
@endsection