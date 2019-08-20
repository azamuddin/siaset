@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="col-md-6 offset-md-3">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Kode aset</td>
                        <td>{{$aset->kode}}</td>
                    </tr>
                    <tr>
                        <td>Foto</td>
                        <td>
                            @if(isset($aset->photo_url))
                                <img width="250px" src="{{asset("/storage/$aset->photo_url")}}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Nama aset</td>
                        <td>{{$aset->nama_aset}}</td>
                    </tr>
                    <tr>
                        <td>Jenis</td>
                        <td>{{$aset->jenis}}</td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>{{$aset->kategori->nama_kategori}}</td>
                    </tr>
                    <tr>
                        <td>Satker</td>
                        <td>{{$aset->satker->nama_satker}}</td>
                    </tr>

                    <tr>
                        <td>Kondisi</td>
                        <td>{{$aset->kondisi}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal terima</td>
                        <td>{{\Carbon\Carbon::create($aset->tgl_terima)->format('m/d/Y')}}</td>
                    </tr>
                    <tr>
                        <td>Nilai perolehan</td>
                        <td>Rp{{number_format($aset->nilai_perolehan)}}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>
                            {{$aset->keterangan}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
