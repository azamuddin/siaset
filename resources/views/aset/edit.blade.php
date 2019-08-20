@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message')}}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{url("aset/$aset->id")}}" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="_method" value="PUT">

                {{ csrf_field() }}

                <div class="form-group">
                    <label> Kode aset </label>
                    <input type="text" value="{{$aset->kode}}" class="form-control" name="kode" />
                </div>

                <div class="form-group">
                    <label for="">Foto</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nama aset</label>
                    <input type="text" value="{{$aset->nama_aset}}" name="nama_aset" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nilai perolehan</label>
                    <input type="text" name="nilai_perolehan" value="{{$aset->nilai_perolehan}}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" cols="30" rows="4" class="form-control">{{$aset->keterangan}}</textarea>
                </div>

                <div class="form-group">
                    <label> Tanggal terima </label>
                    <input type="text" autocomplete="off" value="{{\Carbon\Carbon::create($aset->tgl_terima)->format('m/d/Y')}}" class=" tanggal" name="tgl_terima">
                </div>

                <div class="form-group">
                    <label> Kondisi </label>
                    <select class=form-control name="kondisi">
                        <option {{$aset->kondisi == "BAIK" ? "selected": ""}} value="BAIK">BAIK</option>
                        <option {{$aset->kondisi == "RUSAK" ? "selected" : ""}} value="RUSAK">RUSAK</option>
                    </select>
                </div>

                <div class="form-group">
                    <label> Jenis </label>
                    <select class=form-control name="jenis">
                        <option {{$aset->jenis == "BERGERAK" ? "selected" : ""}} value="BERGERAK">ASET BERGERAK</option>
                        <option {{$aset->jenis == "TETAP" ? "selected" : ""}} value="TETAP">ASET TETAP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option {{$aset->kategori_id == $k->id ? "selected" : ""}} value="{{$k->id}}"> {{$k->nama_kategori}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Satker</label>
                    <select name="satker_id" class="form-control">
                        <option value="">Pilih satker</option>
                        @foreach($satker as $s)
                            <option {{$aset->satker_id == $s->id ? "selected" : ""}} value="{{$s->id}}"> {{$s->nama_satker}} </option>
                        @endforeach
                    </select>
                </div>

                <input type="submit" class="btn btn-primary" value="Simpan">


            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('input.tanggal').datepicker();
        })

    </script>
@endpush
