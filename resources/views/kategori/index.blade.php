@extends("layouts/app")

@section('content')
<div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 pt-5">
                    <h3>Daftar Kategori</h3>
                    <br>
                    <a href="{{url('kategori/create') }}" class="btn btn-primary">Tambah</a>
                    <br>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Kategori</th>
                                <th>Nama kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semua_kategori as $kategori)
                                <tr>
                                    <td>
                                        {{$kategori->id}}
                                    </td>
                                    <td>
                                        {{$kategori->nama_kategori}}
                                    </td>
                                    <td>
                                        <a href="{{ url("kategori/$kategori->id/edit") }}" class="btn btn-info"> Edit </a>
                                        <a href="{{ url("kategori/$kategori->id/delete") }}" class="btn btn-danger"> Hapus </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{$semua_kategori->links()}}
                </div>
            </div>
        </div>


@endsection
