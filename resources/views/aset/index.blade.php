@extends('layouts.app')


@section('content')
    <div class="container pt-5">
        <h4>Daftar aset</h4>

        <a href="{{url('/aset/create')}}" class="btn btn-primary"> Tambah </a>
        <a href="{{url('/aset/import')}}" class="btn btn-success"> Import </a>
        <br/>
        <br/>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID </th>
                    <th>Foto</th>
                    <th>Kode aset</th>
                    <th>Nama aset</th>
                    <th>Kondisi</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Satker</th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach($semua_aset as $aset)
                <tr>
                    <td> {{$aset->id}}</td>
                    <td>
                        @if(isset($aset->photo_url))
                          <img width="100px" src="{{asset("/storage/$aset->photo_url")}}" alt="foto">
                        @else
                           -
                        @endif
                    </td>
                    <td> {{$aset->kode}}</td>
                    <td> {{$aset->nama_aset}} </td>
                    <td> {{$aset->kondisi}} </td>
                    <td> {{$aset->jenis}} </td>
                    <td> {{$aset->kategori->nama_kategori}} </td>
                    <td> {{$aset->satker->nama_satker}} </td>
                    <td>
                        <a href="{{url("/aset/$aset->id/edit")}}" class="btn btn-info btn-sm">edit </a>
                        <a href="{{url("/aset/$aset->id")}}" class="btn btn-info btn-sm">view </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="10">{{$semua_aset->links()}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
