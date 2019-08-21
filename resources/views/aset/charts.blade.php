
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Dashboard charts</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="pie-by-jenis"></div>
        </div>
        <div class="col-md-6">
            <div id="pie-by-kondisi"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="pie-by-kategori"></div>
        </div>
        <div class="col-md-6">
            <div id="pie-by-satker"></div>
        </div>
    </div>
</div>

@piechart('pie_by_jenis', 'pie-by-jenis')
@piechart('pie_by_kondisi', 'pie-by-kondisi')
@piechart('pie_by_kategori', 'pie-by-kategori')
@piechart('pie_by_satker', 'pie-by-satker')
@endsection
