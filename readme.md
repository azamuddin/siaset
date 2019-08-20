# Petunjuk pelatihan Hari ke 3

## A. Materi:

-   CRUD `Aset`
-   Upload foto `Aset`
-   Request Validation CRUD `Aset`
-   Authorization
-   Charts
-   Import & Export Excel

## B. CRUD `Aset`

### B.1. Buat table `aset` menggunakan migration

Jalankan perintah ini di CMDer / CMD, pastikan sudah di path / lokasi project Anda:

```
php artisan make:migration create_aset_table
```

Setelah berhasil, buka file `migration` yang tercreate yaitu terletak di `database/migrations/xxxx_xx_xx_xxxxx_create_aset_table.php` misalnya `2019_08_20_154513_create_aset_table.php`.

Lalu ubah agar kode `migration` tersebut menjadi seperti ini:

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('kondisi', ["BAIK", "RUSAK"]);
            $table->enum('jenis', ['TETAP', 'BERGERAK']);
            $table->string('nama_aset', 255);
            $table->string('kode', 255);
            $table->integer('nilai_perolehan');
            $table->text('keterangan');
            $table->timestamp('tgl_terima');
            $table->string('photo_url')->nullable();
            $table->integer('satker_id')->unsigned();
            $table->integer('kategori_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset');
    }
}

```

Setelah itu eksekusi perintah ini untuk membuat table berdasarkan `migration` di atas:

```
php artisan migrate
```

> Anda bisa mengecek table yang dibuat pada phpmyadmin di alamat localhost/phpmyadmin

### B.2 Buat model `Aset`

pada CMDer / CMD ketik:

```
php artisan make:model Aset
```

Lalu buka model tersebut yang terletak di `app/Aset.php`

dan beritahu laravel bahwa kita akan menggunakan table `aset`, dengan mengubah file `Aset.php` tersebut sehingga terlihat seperti ini:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table = 'aset';
}

```

### B.3. Buat `AsetController`

Jalankan perintah ini:

```
php artisan make:controller AsetController --resource
```

Setelah itu controller akan tercreate di `app/Http/Controllers/AsetController.php`

Untuk sementara biarkan dulu file tersebut.

### B.4. Buat Route akses ke `AsetController`

Buka file `routes/web.php`

Lalu tambahkan kode route resource untuk `AsetController` seperti ini:

```php
Route::resource('/aset', 'AsetController');
```

### B.5. Buat fitur create `Aset`

#### B.5.1 buka `AsetController` lalu ubah agar action `create` menjadi seperti ini:

```php
public function create()
{
    $kategori = Kategori::all(); // karena kita perlu data kategori di form create
    $satker = Satker::all(); // dan perlu data satker juga

    return view('aset/create', compact('kategori', 'satker'));
}
```

Jangan lupa karena kita menggunakan model `Kategori` dan `Satker` di `AsetController` ini, di bagian atas file di bawah `namespace ...` tambahkan kode ini:

```php
use App\Kategori;
use App\Satker;
```

#### B.5.2 Tambahkan script dan css untuk gijgo di layouts

Buka file `app/resources/layouts/app.blade.php`. cari kode berikut:

```html
<script src="{{ asset('js/app.js') }}" defer></script>
```

Lalu replace dengan kode ini:

```html
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js "></script>
```

> perhatikan! untuk script `js/app.js` sebelumnya menggunakan `defer` lalu kita hapus.

Juga cari kode berikut:

```html
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
```

Dan replace dengan kode ini:

```html
<link
    rel="stylesheet"
    href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css"
/>
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
```

Kode gijgo berguna untuk membuat input-input khusus seperti datetime, timepicker, editor, dll. Selengkapnya bisa baca di https://gijgo.com/

Setelah itu cari kode berikut:

```html
<main class="py-4">
    @yield('content')
</main>
```

Dan replace dengan kode ini:

```html
<main class="py-4">
    @yield('content')
</main>
@stack('scripts')
```

#### B.5.3 Buat file views untuk create

Buat folder `aset` pada `app/resources/views` lalu di dalam folder `aset` tersebut buat file `create.blade.php`.

Setelah itu isi dengan kode berikut:

```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message')}}
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

            <form action="{{url('/aset')}}" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="form-group">
                    <label> Kode aset </label>
                    <input type="text" class="form-control" name="kode" />
                </div>

                <div class="form-group">
                    <label for="">Foto</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nama aset</label>
                    <input type="text" name="nama_aset" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nilai perolehan</label>
                    <input type="text" name="nilai_perolehan" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" cols="30" rows="4" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label> Tanggal terima </label>
                    <input type="text" class=" tanggal" name="tgl_terima" autocomplete="off">
                </div>

                <div class="form-group">
                    <label> Kondisi </label>
                    <select class=form-control name="kondisi">
                        <option value="BAIK">BAIK</option>
                        <option value="RUSAK">RUSAK</option>
                    </select>
                </div>

                <div class="form-group">
                    <label> Jenis </label>
                    <select class=form-control name="jenis">
                        <option value="BERGERAK">ASET BERGERAK</option>
                        <option value="TETAP">ASET TETAP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{$k->id}}"> {{$k->nama_kategori}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Satker</label>
                    <select name="satker_id" class="form-control">
                        <option value="">Pilih satker</option>
                        @foreach($satker as $s)
                            <option value="{{$s->id}}"> {{$s->nama_satker}} </option>
                        @endforeach
                    </select>
                </div>


                <input type="submit" class="btn btn-primary" value="Simpan">


            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('input.tanggal').datepicker();
        })
    </script>
@endpush

```

#### B.5.4 Tangkap dan simpan data dari form ke database

Ubah file `AsetController` lalu sesuaikan method `store` agar menjadi seperti ini:

```php
public function store(Request $request)
{

    $aset_baru = new Aset;
    $aset_baru->kode = $request->kode;
    $aset_baru->nama_aset = $request->nama_aset;
    $aset_baru->keterangan = $request->keterangan;
    $aset_baru->nilai_perolehan = $request->nilai_perolehan;
    $aset_baru->satker_id = $request->satker_id;
    $aset_baru->kategori_id = $request->kategori_id;
    $aset_baru->jenis = $request->jenis;
    $aset_baru->kondisi = $request->kondisi;
    $aset_baru->tgl_terima = Carbon::create($request->tgl_terima);

    $aset_baru->save();

    return redirect()->to('/aset/create')->with('message', 'Berhasil menambahkan aset');
}
```

Karena pada kode di atas menggunakan model `Aset` dan juga menggunakan `Class` khusus untuk mengelola tanggal, yaitu `Carbon` pastikan kita sudah menambahkan kode ini di bagian atas:

```php
use App\Aset;
use Carbon\Carbon;
```

### B.6 Upload foto

#### B.6.1 Buat symbolic link supaya file yang diupload bisa diakses

jalankan perintah berikut di CMDer / CMD:

```
php artisan storage:link
```

#### B.6.2 Sesuaikan file views `app/resources/aset/create.blade.php`

Tambahkan input untuk upload file yaitu:

```php
<div class="form-group">
    <label for="">Foto</label>
    <input type="file" name="photo" class="form-control">
</div>
```

Tambahkan kode di atas misalnya setelah input untuk nama aset, atau di mana saja di antara kode `<form ...>` dan `</form>`

#### B.6.3 Tangkap file dan simpan ke filesistem

Buka file `app/Http/Controllers/AsetController.php` lalu tambahkan kode ini pada method `store` untuk menangkap file dan menyimpan:

```php

if ($request->hasFile('photo')) {
    $fd = $request->file('photo')->store("/aset/", 'public');
}

$aset_baru->photo_url = $fd;

```

Sehingga method `store` sekarang menjadi seperti ini:

```php
public function store(Request $request)
{

    $aset_baru = new Aset;
    $aset_baru->kode = $request->kode;
    $aset_baru->nama_aset = $request->nama_aset;
    $aset_baru->keterangan = $request->keterangan;
    $aset_baru->nilai_perolehan = $request->nilai_perolehan;
    $aset_baru->satker_id = $request->satker_id;
    $aset_baru->kategori_id = $request->kategori_id;
    $aset_baru->jenis = $request->jenis;
    $aset_baru->kondisi = $request->kondisi;
    $aset_baru->tgl_terima = Carbon::create($request->tgl_terima);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store("/aset/", 'public');
        $aset_baru->photo_url = $path; // simpan path foto pada database dengan field 'photo_url'
    }

    $aset_baru->save();


    return redirect()->to('/aset/create')->with('message', 'Berhasil menambahkan aset');
}
```

### B.7 Request validation

Kita sudah bisa membuat aset baru dan mengupload file, tapi kita belum melakukan validasi input dari user. Hal ini untuk memastikan input sudah valid dan mencegah serangan terhadap aplikasi kita.

Buka file `app/Http/Controllers/AsetController.php` lalu pada method `store` tambahkan kode berikut:

```php
$request->validate([
    "nama_aset" => "required|min:4|max:255",
    "kode" => "required|min:3|max:255",
    "photo" => "file|image|mimes:jpeg,png,gif,webp|max:2048",
    "jenis" => "required",
    "kategori_id" => "required",
    "lokasi_id" => "required",
    "tgl_terima" => "required",
    "kondisi" => "required",
    "satker_id" => "required",
    "nilai_perolehan" => "required"
]);
```
