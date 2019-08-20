@extends('layouts/app')

@section('content')
        <div class="container pt-4">
            <div class="col-md-8 offset-md-2">

                <h3>Hapus satker?</h3>

                <form method="POST" action="{{ url("satker/$satker->id") }}">

                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="DELETE">

                    Anda yakin ingin menghapus {{$satker->nama_satker}}?
                    <br>
                    <br>
                    <a href=" {{ url("satker") }} " class="btn btn-default">Batalkan</a>
                    <input type="submit" value="Ya hapus" class="btn btn-danger">

                </form>
            </div>
        </div>
@endsection
