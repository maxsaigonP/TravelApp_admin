@extends('layouts.admin')

@section('title','Thêm địa danh nhu cầu')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm địa danh nhu cầu</h4>
             @if(session('error')) 
                <li class="text-danger" >{{ session('error') }}</li>
            @endif
            <hr>
            <form class="forms-sample" action="{{ route('diaDanhNhuCau.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                     <select class="form-control text-light" name="idDiaDanh" >
                         @foreach($lstDiaDanh as $dd)
                            <option value="{{$dd->id}}">{{$dd->tenDiaDanh}}</option>
                         @endforeach
                     </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Nhu cầu</label>
                    <select class="form-control text-light" name="idNhuCau" >
                         @foreach($lstNhuCau as $nc)
                            <option value="{{$nc->id}}">{{$nc->tenNhuCau}}</option>
                         @endforeach
                     </select>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection