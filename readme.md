# Petunjuk pelatihan Hari ke 3

## A. Outline:

-   A. Outline
-   B. CRUD `Aset`
-   B.7 Request Validation `Aset`
-   C. Authorization / Otorisasi
-   D. Import & Export Excel
-   E. Charts
-   F. Membat menu topbar

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
            $table->string('kode', 255)->unique();
            $table->integer('nilai_perolehan');
            $table->text('keterangan');
            $table->timestamp('tgl_terima');
            $table->text('photo_url')->nullable();
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
    $path = $request->file('photo')->store("/aset/", 'public');
    $aset_baru->photo_url = $path;
}

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
    "kode" => "required|min:3|max:255|unique",
    "photo" => "file|image|mimes:jpeg,png,gif,webp|max:2048",
    "jenis" => "required",
    "kategori_id" => "required",
    "tgl_terima" => "required",
    "kondisi" => "required",
    "satker_id" => "required",
    "nilai_perolehan" => "required"
]);
```

### B.8 Menampilkan daftar aset

#### B.8.1 Buka `AsetController` dan sesuaikan method `index`

```php
public function index()
{
    $semua_aset = Aset::orderBy('id', 'DESC')->paginate(10);

    return view('aset/index', compact('semua_aset'));
}
```

#### B.8.2 Buat file views `app/resources/aset/index.blade.php`

lalu isi kode berikut:

```html
@extends('layouts.app')


@section('content')
    <div class="container pt-5">
        <h4>Daftar aset</h4>

        <a href="{{url('/aset/create')}}" class="btn btn-primary"> Tambah </a>
        <br/>
        <br/>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID </th>
                    <th>Foto</th>
                    <th>Kode aset</th>
                    <th>Nama aset</th>
                    <th>Kondisi</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Satker</th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach($semua_aset as $aset)
                <tr>
                    <td> {{$aset->id}}</td>
                    <td>
                        @if(isset($aset->photo_url))
                          <img width="100px" src="{{asset("/storage/$aset->photo_url")}}" alt="foto">
                        @else
                           -
                        @endif
                    </td>
                    <td> {{$aset->kode}}</td>
                    <td> {{$aset->nama_aset}} </td>
                    <td> {{$aset->kondisi}} </td>
                    <td> {{$aset->jenis}} </td>
                    <td> {{$aset->kategori_id}} </td>
                    <td> {{$aset->satker_id}} </td>
                    <td>
                        <a href="{{url("/aset/$aset->id/edit")}}" class="btn btn-info btn-sm">edit </a>
                        <a href="{{url("/aset/$aset->id")}}" class="btn btn-info btn-sm">view </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="10">{{$semua_aset->links()}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

```

#### B.8.3 Relationship

Kita sudah bisa menampilkan daftar aset, tapi perhatikan field satker_id dan kategori_id, kita hanya bisa menampilkan id nya saja, padahal kita ingin bisa menampilkan nama_satker dan nama_kategori dari aset tersebut.

Untuk itu kita perlu atur `relationship` antara model yaitu:

-   model `Aset` punya satu relationhip dengan `Kategori`
-   model `Aset` punya satu relationship dengan `Satker`

caranya, buka model `app/Aset.php` lalu tambahkan dua method ini:

```php
public function satker()
{
    return $this->belongsTo('App\Satker', 'satker_id');
}

public function kategori()
{
    return $this->belongsTo('App\Kategori', 'kategori_id');
}
```

Jika sudah ubah kode pada views `app/resources/aset/index.blade.php` cari kode berikut ini:

```php
<td> {{$aset->kategori_id}} </td>
<td> {{$aset->satker_id}} </td>
```

Lalu ubah dengan kode ini:

```php
<td> {{$aset->kategori->nama_kategori}} </td>
<td> {{$aset->satker->nama_satker}} </td>
```

### B.9 menampilkan detail view `Aset`

Buka file `app/Http/Controllers/AsetController.php`
lalu sesuaikan method `show` agar menjadi seperti ini:

```php

$aset = Aset::findOrFail($id);

return view('aset/show', compact('aset'));

```

Lalu buat view pada `app/resources/views/aset/show.blade.php`

```php
@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="col-md-6 offset-md-3">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Kode aset</td>
                        <td>{{$aset->kode}}</td>
                    </tr>
                    <tr>
                        <td>Foto</td>
                        <td>
                            @if(isset($aset->photo_url))
                                <img width="250px" src="{{asset("/storage/$aset->photo_url")}}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Nama aset</td>
                        <td>{{$aset->nama_aset}}</td>
                    </tr>
                    <tr>
                        <td>Jenis</td>
                        <td>{{$aset->jenis}}</td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>{{$aset->kategori->nama_kategori}}</td>
                    </tr>
                    <tr>
                        <td>Satker</td>
                        <td>{{$aset->satker->nama_satker}}</td>
                    </tr>

                    <tr>
                        <td>Kondisi</td>
                        <td>{{$aset->kondisi}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal terima</td>
                        <td>{{\Carbon\Carbon::create($aset->tgl_terima)->format('m/d/Y')}}</td>
                    </tr>
                    <tr>
                        <td>Nilai perolehan</td>
                        <td>Rp{{number_format($aset->nilai_perolehan)}}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>
                            {{$aset->keterangan}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

```

### B.10 Edit aset

#### B.10.1 Sesuaikan method edit pada `AsetController` seperti ini:

```php
public function edit($id){
    $aset = Aset::findOrFail($id);
    $kategori = Kategori::all();
    $satker = Satker::all();

    return view('aset/edit', compact('aset', 'kategori', 'satker'));
}
```

#### B.10.2 Buat views untuk edit aset

Lalu buat file views `app/resources/views/aset/edit.blade.php`

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

            <form action="{{url("aset/$aset->id")}}" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="_method" value="PUT">

                {{ csrf_field() }}

                <div class="form-group">
                    <label> Kode aset </label>
                    <input type="text" value="{{$aset->kode}}" class="form-control" name="kode" />
                </div>

                <div class="form-group">
                    <label for="">Foto</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nama aset</label>
                    <input type="text" value="{{$aset->nama_aset}}" name="nama_aset" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Nilai perolehan</label>
                    <input type="text" name="nilai_perolehan" value="{{$aset->nilai_perolehan}}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" cols="30" rows="4" class="form-control">{{$aset->keterangan}}</textarea>
                </div>

                <div class="form-group">
                    <label> Tanggal terima </label>
                    <input type="text" autocomplete="off" value="{{\Carbon\Carbon::create($aset->tgl_terima)->format('m/d/Y')}}" class=" tanggal" name="tgl_terima">
                </div>

                <div class="form-group">
                    <label> Kondisi </label>
                    <select class=form-control name="kondisi">
                        <option {{$aset->kondisi == "BAIK" ? "selected": ""}} value="BAIK">BAIK</option>
                        <option {{$aset->kondisi == "RUSAK" ? "selected" : ""}} value="RUSAK">RUSAK</option>
                    </select>
                </div>

                <div class="form-group">
                    <label> Jenis </label>
                    <select class=form-control name="jenis">
                        <option {{$aset->jenis == "BERGERAK" ? "selected" : ""}} value="BERGERAK">ASET BERGERAK</option>
                        <option {{$aset->jenis == "TETAP" ? "selected" : ""}} value="TETAP">ASET TETAP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option {{$aset->kategori_id == $k->id ? "selected" : ""}} value="{{$k->id}}"> {{$k->nama_kategori}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Satker</label>
                    <select name="satker_id" class="form-control">
                        <option value="">Pilih satker</option>
                        @foreach($satker as $s)
                            <option {{$aset->satker_id == $s->id ? "selected" : ""}} value="{{$s->id}}"> {{$s->nama_satker}} </option>
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

#### B.10.3 Tangkap data edit dan simpan ke database

Pada `AsetController` method `update` jadikan seperti ini:

```php
public function update(Request $request, $id)
    {
        $request->validate([
            "nama_aset" => "required|min:4|max:255",
            "kode" => "required|min:3|max:255|unique",
            "photo" => "file|image|mimes:jpeg,png,gif,webp|max:2048",
            "jenis" => "required",
            "kategori_id" => "required",
            "tgl_terima" => "required",
            "kondisi" => "required",
            "satker_id" => "required",
            "nilai_perolehan" => "required"
        ]);

        $aset = Aset::findOrFail($id);
        $aset->kode = $request->kode;
        $aset->nama_aset = $request->nama_aset;
        $aset->keterangan = $request->keterangan;
        $aset->nilai_perolehan = $request->nilai_perolehan;
        $aset->satker_id = $request->satker_id;
        $aset->kategori_id = $request->kategori_id;
        $aset->jenis = $request->jenis;
        $aset->kondisi = $request->kondisi;
        $aset->tgl_terima = Carbon::create($request->tgl_terima);

        if ($request->hasFile('photo')) {

            // hapus foto lama
            \Storage::delete($aset->photo_url);

            // simpan foto baru
            $path = $request->file('photo')->store("aset/$aset->id", "public");

            $aset->photo_url = $path;
        }

        $aset->save();

        return redirect()->to("/aset/$id/edit")->with("message", "Berhasil mengupdate aset");
    }

```

## C. Otorisasi

### C.1 sesuaikan struktur table `users`

Tambahkan field baru pada table users, yaitu field `role` dengan tipe `enum` dan bernilai `OPERATOR` atau `ADMINISTRATOR`

caranya, buat file migration terlebih dahulu dengan perintah berikut:

```
php artisan make:migration alter_table_users_add_role --table=users
```

Lalu buka file `migration` yang tercreate, dan jadikan method `up` menjadi seperti ini:

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['OPERATOR', 'ADMINISTRATOR']);
    });
}
```

Setelah itu jalankan perintah migrate seperti ini:

```php
php artisan migrate
```

Jika sudah, maka sekarang di table `users` sudah ada field `role`, bisa dicek melalui `phpmyadmin`.

### C.2 Buat gate

Buka file `app/Providers/AuthServiceProvider.php`, tambahkan kode berikut ini pada method `boot()` di file tersebut:

```php
\Gate::define('kelola-kategori', function ($user) {
    return $user->role == "ADMINISTRATOR";
});

\Gate::define('kelola-satker', function ($user) {
    return $user->role == "ADMINISTRATOR";
});
```

### C.3 gunakan gate di masing-masing Controller action yang memerlukan

Misal, kita ingin yang bisa mengelola kategori hanyalah admin, dan kita sudah mendefinisikannya pada Gate yaitu "kelola-kategori", maka sekarang buka file `app/Http/Controllers/KategoriController.php` dan tambahkan kode ini pada semua method di controller tersebut:

```php
$this->authorize('kelola-kategori');
```

Misalnya pada method `index` akan terlihat seperti ini:

```php
public function index()
{
    $this->authorize('kelola-kategori');

    $semua_kategori = Kategori::orderBy->('id', 'DESC')->paginate(10);

    return view('kategori/index', compact('semua_kategori'));
}
```

> lanjutkan ke semua method yang lain: create, store, edit, update, destroy, delete

Setelah itu Lakukan langkah yang sama untuk `SatkerController` perbedaannya ubah `kelola-kategori` dengan `kelola-satker`

### C.4 khusus Aset, kita ingin semua role bisa memodifikasi, tapi jika belum login tidak bisa

Untuk keperluan ini kita tidak perlu Gate, kita langsung ke `AsetController` dan tambahkan kode berikut pada setiap method:

```php
if (!\Auth::check()) {
    abort(401);
}
```

Misalnya untuk method `create` akan terlihat seperti ini:

```php
public function create()
{

    if (!\Auth::check()) {
        abort(401);
    }

    $kategori = Kategori::all();
    $satker = Satker::all();

    return view('aset/create', compact('kategori', 'satker'));
}
```

## D. Import & Export Excel

### D.1 Install package maatwebsite/excel

https://docs.laravel-excel.com/3.1/getting-started/installation.html

jalankan perintah di CMDer / CMD:

```
composer require maatwebsite/excel
```

Kemudian publish konfigurasi yang dibawa oleh package tersebut, dengan mengetik perintah ini di CMDer / CMD:

```
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

Perintah tersebut akan membuat file baru di `config/excel.php`.

### D.2 Import

#### D.2.1 buat file import baru

Setelah menginstall maatwebsite/excel, sekarang kita punya perintah artisan `make:import`.

Ketik perintah di CMDer/ CMD:

```
php artisan make:import AsetImports --model=Aset
```

File baru akan tercreate di `app/Imports/AsetImports.php`

#### D.2.2 sesuaikan file `app/Imports/AsetImports.php`

Pastikan class `AsetImports` menjadi seperti di bawah ini:

```php

class AsetImports implements OnEachRow, WithHeadingRow
{

    public function onRow(Row $row)
    {

        $row = $row->toArray();

        $satker = Satker::where("nama_satker", $row["satker"])->first();

        if(!$satker){
            // jika belum ada satker dengan nama sesuai nilai $row["satker"] buat satker baru
            $satker = new Satker;
            $satker->nama_satker = $row["satker"];
            $satker->save();
        }

        $kategori = Kategori::where("nama_kategori", $row["kategori"])->first();

        if(!$kategori){
            $kategori = new Kategori;
            $kategori->nama_kategori = $row["kategori"];
            $kategori->save();
        }

        // asumsi column pertama di file excel adalah kode aset
        $aset = new Aset;
        $aset->kode = $row["kode"];
        $aset->nama_aset = $row["nama"];
        $aset->nilai_perolehan = $row["nilai_perolehan"];
        $aset->jenis = $row["jenis"];
        $aset->kondisi = $row["kondisi"];
        $aset->satker_id = $satker->id;
        $aset->kategori_id = $kategori->id;
        $aset->tgl_terima = Carbon::create($row["tgl_terima"]);
        $aset->keterangan = $row["keterangan"];
        $aset->save();
    }
}

```

> Jangan lupa karena kita menggunakan model `Satker`, `Kategori`, `Aset` serta class `Carbon`, `OnEachRow`, `WithHeadingRow` dan `Row` maka kita perlu memberi tahu file-file tersebut asalnya dari mana, dengan memberikan kode berikut ini di bagian atas file setelah `namespace`:

```php
use App\Aset;
use App\Kategori;
use App\Satker;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
```

#### D.2.3 buat method `import` di `AsetController` untuk menampilkan form import

```php
public function import()
{
    return view("aset/import");
}
```

#### D.2.4 buat view `app/resources/views/aset/import.blade.php`

File view ini untuk menampilkan form upload excel untuk import

```php
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

```

#### D.2.5 buat method `processImport` pada `AsetController`

method ini berfungsi untuk menangkap file excel yang diupload dan kita import ke database memanfaatkan file `AsetImports` yang kita buat sebelumnya.

```php
public function processImport(Request $request)
{
    $request->validate([
        "aset-excel" => "required|file|mimes:xls,xlsx|max:10000"
    ]);

    Excel::import(new AsetImports, $request->file('aset-excel'));

    return redirect()->to('/aset/import')->with('message', 'Data aset telah berhasil diimport');
}
```

> Karena kita menggunakan class `AsetImports` jangan lupa tambahkan kode `use App\Imports\AsetImports;` di bagian atas file.

#### D.2.6 buat tombol ke halaman import dari daftar aset

Buka file `app/resources/views/aset/index.blade.php`
lalu tambahkan kode ini:

```php
<a href="{{url('/aset/import')}}" class="btn btn-success"> Import </a>
```

Setelah kode ini:

```php
<a href="{{url('/aset/create')}}" class="btn btn-primary"> Tambah </a>
```

#### D.2.7 Buat route ke dua method yang kita buat yaitu `import` dan `processImport`

Buka file `routes/web.php`, tambahkan route berikut:

```php
Route::get('/aset/import', 'AsetController@import');
Route::post('/aset/import', 'AsetController@processImport');
```

Pastikan letak route baru tersebut ada di atas route resource aset ini:

```php
Route::resource('/aset', 'AsetController');
```

### D.3 Exports

#### D.3.1 buat file `AsetExports`

Ketik perintah ini di CMDer / CMD:

```
php artisan make:export AsetExports
```

File baru akan tercreate pada `app/Exports/AsetExports.php`

#### D.3.2 Sesuaikan file `AsetExports` yang tergenerate

```php
<?php

namespace App\Exports;

use App\Aset;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class AsetExports implements FromCollection
{

    use Exportable;

    public function collection()
    {
        return Aset::all();
    }
}

```

#### D.3.3 buat method `export` pada `AsetController`

```php
public function export(){
    $export = new AsetExports;
    return $export->download('aset.xlsx');
}
```

> Jangan lupa karena kita menggunakan `AsetExports` maka kita tambahkan kode `use App\Exports\AsetExports` pada bagian atas file `AsetController.php`

#### D.3.4 buat route untuk export pada `routes/web.php`

```php
Route::get('/aset/export', 'AsetController@export');
```

Letakkan kode di atas di atas `Route::resource` untuk `/aset`.

#### D.3.4 Buat tombol export dari halaman daftar aset

Tambahkan kode berikut ini di `app/resources/views/aset/index.blade.php`

```php
<a href="{{action('AsetController@export')}}" class="btn btn-info"> Export </a>
```

E. Charts

E.1 Install lavacharts

```
composer require khill/lavacharts
```

E.2 atur konfigurasi

buka file `app/config/app.php`
lalu tambahkan kode berikut pada key `providers`:

```
Khill\Lavacharts\Laravel\LavachartsServiceProvider::class
```

Lalu pada key `aliases` tambahkan:

```
'Lava' => Khill\Lavacharts\Laravel\LavachartsFacade::class
```

E.3 Buat method charts pada `AsetController`

```php
public function charts(){
    $dataTable = \Lava::DataTable();

    $dataTable->addStringColumn('Jenis')
        ->addNumberColumn('Percent');


    $aset_count = Aset::count();
    $aset_by_jenis = Aset::groupBy('jenis')
        ->select('jenis', \DB::raw('count(*) as count'))
        ->get();

    foreach ($aset_by_jenis as $jenis) {
        $dataTable->addRow([$jenis->jenis, $jenis->count / $aset_count]);
    }

    $pieByJenis = \Lava::PieChart('pie_by_jenis', $dataTable, [
        'title'  => 'Aset berdasarkan jenis',
        'is3D'   => true,
        'slices' => [
            ['offset' => 0.2],
            ['offset' => 0.25],
            ['offset' => 0.3]
        ]
    ]);

    // aset by kondisi

        $aset_by_kondisi = Aset::groupBy('kondisi')
            ->select('kondisi', \DB::raw('count(*) as count'))
            ->get();

        $byKondisiTable = \Lava::DataTable();

        $byKondisiTable
            ->addStringColumn('kondisi')
            ->addNumberColumn('percent');

        foreach ($aset_by_kondisi as $kondisi) {
            $byKondisiTable->addRow([$kondisi->kondisi, $kondisi->count / $aset_count]);
        }

        $pieByKondisi = \Lava::PieChart('pie_by_kondisi', $byKondisiTable);

        // aset by kategori

        $aset_by_kategori = Aset::with('kategori')->get()->map(function ($aset) {
            $aset->nama_kategori = $aset->kategori->nama_kategori;
            return $aset;
        })->groupBy('nama_kategori');

        $byKategoriTable = \Lava::DataTable()
            ->addStringColumn('kategori')
            ->addNumberColumn('jumlah');

        foreach ($aset_by_kategori as $kategori) {
            $nama_kategori = $kategori->pluck('nama_kategori')[0];
            $byKategoriTable->addRow([$nama_kategori, count($kategori)]);
        }

        $pieByKategori = \Lava::PieChart('pie_by_kategori', $byKategoriTable, [
            "title" => "Aset berdasarkan kategori",
            "orientation" => "horizontal"
        ]);


        // aset by satker
        $aset_by_satker = Aset::with('satker')->get()->map(function ($aset) {
            $aset->nama_satker = $aset->satker->nama_satker;
            return $aset;
        })->groupBy('nama_satker');

        $byKategoriTable = \Lava::DataTable()
            ->addStringColumn('satker')
            ->addNumberColumn('jumlah');

        foreach ($aset_by_satker as $satker) {
            $nama_satker = $satker->pluck('nama_satker')[0];
            $byKategoriTable->addRow([$nama_satker, count($satker)]);
        }

        $pieBySatker = \Lava::PieChart('pie_by_satker', $byKategoriTable, [
            "title" => "Aset berdasarkan satker",
            "orientation" => "horizontal"
        ]);

        return view('aset/charts', compact('pieByJenis', 'pieByKondisi', 'pieByKategori', 'pieBySatker'));


}
```

E.4 buat view `app/resources/views/charts.blade.php`

```php

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

```

E.5 buat route untuk charts di `routes/web.php`

```php
Route::get('/aset/charts', 'AsetController@charts');
```

Letakan di atas resource route untuk charts

## F. Membuat menu pada topbar

Buka file `resources/views/layouts/app.blade.php`

Lalu cari kode berikut ini:

```php
<ul class="navbar-nav mr-auto">
```

Lalu tambahkan kode berikut dibawahnya:

```php
@if(\Gate::allows('kelola-kategori'))
    <li class="nav-item">
        <a class="nav-link" href="{{ url('kategori') }}">{{ __('Kategori') }}</a>
    </li>
@endif

@if(\Gate::allows('kelola-lokasi'))
    <li class="nav-item">
        <a class="nav-link" href="{{ url('lokasi') }}">{{ __('Lokasi') }}</a>
    </li>
@endif

@if(\Gate::allows('kelola-satker'))
    <li class="nav-item">
        <a class="nav-link" href="{{ url('satker') }}">{{ __('Satker') }}</a>
    </li>
@endif
```
