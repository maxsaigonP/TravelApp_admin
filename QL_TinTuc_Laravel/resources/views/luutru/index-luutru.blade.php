@extends('layouts.admin')

@section('title','Danh sách lưu trú')

@section('content')
<div class="row">
    <div class="col col-lg-6 col-md-12">
        <div class="nav-link d-lg-flex search">
            <input type="text" id="txtSearch" name="txtSearch" class="form-control m-1 text-light" placeholder="Tìm kiếm">
            <button class="btn btn-primary" id="search">Tìm kiếm</button>
        </div>
    </div>
</div>
<div class="page-header">
    <h3 class="page-title"> Danh sách lưu trú </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('luuTru.create') }}">Thêm lưu trú</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách lưu trú</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng lưu trú</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Tên lưu trú </th>
                                <th>Mô tả </th>
                                <th>Địa chỉ</th>
                                <th>Sdt </th>
                                <th>Thời gian hoạt động </th>
                                <th>Hình ảnh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lstLuuTru">
                            @foreach ($lstLuuTru as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->diadanh->tenDiaDanh }}</td>
                                <td>{{ $item->tenLuuTru }}</td>
                                <td>{{ $item->moTa}}</td>
                                <td>{{ $item->diaChi }}</td>
                                <td>{{ $item->sdt}}</td>
                                <td>{{ $item->thoiGianHoatDong }}</td>
                                <td>
                                    <img src="@if($item->hinhAnh != null) {{ asset($item->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="150" />
                                </td>

                                <td>
                                    <label class="badge badge-primary">
                                        <a class="d-block text-light"
                                            href="{{ route('luuTru.edit', ['luuTru'=>$item]) }}"> Sửa</a>
                                    </label>
                                    <!-- <label class="badge badge-success">
                                        <a class="d-block text-light"
                                            href="{{ route('luuTru.show', ['luuTru'=>$item]) }}"> Show</a>
                                    </label> -->
                                    <label>
                                        <form method="post" action="{{ route('luuTru.destroy', ['luuTru'=>$item]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Xoá</button>
                                        </form>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination d-flex justify-content-center">
                    {{ $lstLuuTru->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
        $(document).ready(function() {

            // //Search DiaDanh
            $('#search').on('click', function() {
                var val = $('#txtSearch').val();
                $.ajax({
                    type: "get",
                    url: "/luutru/search",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#lstLuuTru").html(response);
                    }
                });
            });
        });
    </script>

@endsection