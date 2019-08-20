@extends("layouts/app")

@section('content')
<div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 pt-5">
                    <h3>Daftar Satker</h3>
                    <br>
                    <a href="{{url('satker/create') }}" class="btn btn-primary">Tambah</a>
                    <br>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Satker</th>
                                <th>Nama satker</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semua_satker as $satker)
                                <tr>
                                    <td>
                                        {{$satker->id}}
                                    </td>
                                    <td>
                                        {{$satker->nama_satker}}
                                    </td>
                                    <td>
                                        <a href="{{ url("satker/$satker->id/edit") }}" class="btn btn-info"> Edit </a>
                                        <a href="{{ url("satker/$satker->id/delete") }}" class="btn btn-danger"> Hapus </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{$semua_satker->links()}}
                </div>
            </div>
        </div>


@endsection
