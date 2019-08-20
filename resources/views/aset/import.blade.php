@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3">
            <h3>Import data aset</h3>

            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{Session::get('message')}}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="file" name="aset-excel">

                <br>
                <br>

                <input type="submit" value="Upload" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection
