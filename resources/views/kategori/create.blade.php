<html>
    <head>
        <title> Buat kategori </title>
    </head>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <body>
        <div class="container pt-4">
            <div class="col-md-6 offset-md-3">

                <h3>Buat kategori</h3>

                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @endif


                <form action="{{url("/kategori")}}" method="POST">

                    {{csrf_field()}}

                    <input type="text" name="nama_kategori" class="form-control"/>
                    <br>
                    <input type="submit" value="Simpan" class="btn btn-primary">
                </form>
            </div>
        </div>
    </body>

</html>
