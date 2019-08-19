<html>
    <head>
        <title> Daftar kategori </title>
    </head>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <body>
        <div class="container pt-4">
            <div class="col-md-8 offset-md-2">

                <h3>Daftar kategori</h3>

                <a href="{{url('kategori/create')}}" class="btn btn-primary">Tambah</a>
                <br>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semua_kategori as $kategori)
                        <tr>
                            <td>{{$kategori->id}}</td>
                            <td>{{$kategori->nama_kategori}}</td>
                            <td>
                                <a href="{{url("kategori/$kategori->id/edit")}}" class="btn btn-info">Edit</a>
                                <a href="{{url("kategori/$kategori->id/delete")}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$semua_kategori->links()}}
            </div>
        </div>
    </body>

</html>
