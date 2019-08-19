<html>
    <head>
        <title> Hapus kategori </title>
    </head>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <body>
        <div class="container pt-4">
            <div class="col-md-8 offset-md-2">

                <h3>Hapus kategori?</h3>
                <form action="{{url("kategori/$kategori->id")}}" method="POST">
                    <input type="hidden" value="DELETE" name="_method"/>

                    {{csrf_field()}}

                    <div class="alert alert-warning">
                        Anda ingin menghapus kategori {{$kategori->nama_kategori}}?
                    </div>
                    <a href="{{url("kategori")}}" class="btn btn-default">Kembali</a>
                    <input type="submit" value="Ya Hapus" class="btn btn-danger">
                </form>

            </div>
        </div>
    </body>

</html>
