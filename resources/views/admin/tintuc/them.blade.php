@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">News
                    <small>Add</small>
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
                @if(session('loi'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>

                @endif
                <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            @foreach($theloai as $tl)
                            <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type of News</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            @foreach($loaitin as $lt)
                            <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" name="TieuDe" placeholder="Please Enter Category Name" />
                    </div>
                    <div class="form-group">
                        <label>Summary</label>
                        <textarea name="TomTat" class="form-control ckeditor" rows="3" id="demo"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <textarea name="NoiDung" class="form-control ckeditor" rows="5" id="demo"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" name="Hinh" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Hot </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="0" checked="" type="radio">No
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1" type="radio">Yes
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Add</button>
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
        $("#TheLoai").change(function() {
            var idTheLoai = $(this).val();
            $.get("admin/ajax/loaitin/" + idTheLoai, function(data) {
                $("#LoaiTin").html(data);
            });
        });
        var idTheLoai = $('#TheLoai').val();
        $.get("admin/ajax/loaitin/" + idTheLoai, function(data) {
            $("#LoaiTin").html(data);
        });
    });
</script>
@endsection