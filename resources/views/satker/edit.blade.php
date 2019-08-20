@extends("layouts/app")

@section('content')

        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 pt-5">

                    @if(Session::has('pesan'))
                        <div class="alert alert-success">
                            {{ Session::get('pesan') }}
                        </div>
                    @endif

                    <form action="{{url("satker/$satker->id")}}" method="POST">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT">

                        <label>Nama Kategori</label>
                        <input type="text" name="nama_satker" value="{{ $satker->nama_satker }}" class="form-control" />
                        <br>
                        <input type="submit" class="btn btn-primary" value="Simpan">

                        <a href="{{url('satker') }}" class="btn btn-warning">Daftar satker</a>

                    </form>
                </div>
            </div>
        </div>

@endsection
