@extends('layouts/app')

@section('content')
        <div class="container pt-4">
            <div class="col-md-8 offset-md-2">

                <h3>Hapus kategori?</h3>

                <form method="POST" action="{{ url("kategori/$kategori->id") }}">

                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="DELETE">

                    Anda yakin ingin menghapus {{$kategori->nama_kategori}}?
                    <br>
                    <br>
                    <a href=" {{ url("kategori") }} " class="btn btn-default">Batalkan</a>
                    <input type="submit" value="Ya hapus" class="btn btn-danger">

                </form>
            </div>
        </div>
@endsection
