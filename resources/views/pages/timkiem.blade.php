@extends('layout.index')

@section('content')

<div class="container">
    <div class="row">
        @include('layout.menu')

        <?php
        function doiMauChu($str, $keySearch)
        {
            return str_replace($keySearch, "<span style='color:red;'>$keySearch</span>", $str);
        }
        ?>

        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;">
                    <h4><b>Tìm kiếm: {{$keySearch}}</b></h4>
                </div>

                @foreach($tintuc as $tt)
                <div class="row-item row">
                    <div class="col-md-3">

                        <a href="detail.html">
                            <br>
                            <img width="200px" height="200px" class="img-responsive" src="upload/images/tin-tuc/{{$tt->Hinh}}" alt="">
                        </a>
                    </div>

                    <div class="col-md-9">
                        <h3>{!! doiMauChu($tt->TieuDe, $keySearch) !!}</h3>
                        <p>{!! doiMauChu($tt->TomTat, $keySearch) !!}</p>
                        <a class="btn btn-primary" href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}.html">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="break"></div>
                </div>
                @endforeach
                <!-- Pagination -->
                <div style="text-align: center">
                    {{$tintuc->links()}}
                </div>


                <!-- /.row -->

            </div>
        </div>

    </div>

</div>
@endsection