<html>
    <head>
        <title> Edit kategori </title>
    </head>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <body>
        <div class="container pt-4">
            <div class="col-md-6 offset-md-3">

                <h3>Edit kategori</h3>

                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @endif


                <form action="{{url("/kategori/$kategori->id")}}" method="POST">

                    <input type="hidden" name="_method" value="PUT">

                    {{csrf_field()}}

                    <input type="text" value="{{$kategori->nama_kategori}}" name="nama_kategori" class="form-control"/>
                    <br>
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>
    </body>

</html>
