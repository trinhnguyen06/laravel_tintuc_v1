@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
                    <small>{{$slide->Ten}}</small>
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
                <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="Ten" placeholder="Please Enter Slide Name" value="{{$slide->Ten}}" />
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <textarea name="NoiDung" class="form-control ckeditor" rows="5" id="demo">{{$slide->NoiDung}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control" name="link" placeholder="Please Enter Slide Link" value="{{$slide->link}}" />
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <p><img width="400px" src="upload/images/slide/{{$slide->Hinh}}"></p>
                        <input type="file" name="Hinh" class="form-control">
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