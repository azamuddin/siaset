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

                    <form action="{{url("kategori/$kategori->id")}}" method="POST">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT">

                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="form-control" />
                        <br>
                        <input type="submit" class="btn btn-primary" value="Simpan">

                        <a href="{{url('kategori') }}" class="btn btn-warning">Daftar kategori</a>

                    </form>
                </div>
            </div>
        </div>

@endsection
