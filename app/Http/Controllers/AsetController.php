<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Satker;
use App\Aset;
use Carbon\Carbon;
use App\Imports\AsetImports;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\Auth::check()) {
            abort(401);
        }

        $semua_aset = Aset::orderBy('id', 'DESC')->paginate(10);

        return view('aset/index', compact('semua_aset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        $satker = Satker::all();

        return view('aset/create', compact('kategori', 'satker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            "nama_aset" => "required|min:4|max:255",
            "kode" => "required|min:3|max:255",
            "photo" => "file|image|mimes:jpeg,png,gif,webp|max:2048",
            "jenis" => "required",
            "kategori_id" => "required",
            "tgl_terima" => "required",
            "kondisi" => "required",
            "satker_id" => "required",
            "nilai_perolehan" => "required"
        ]);

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
            $fd = $request->file('photo')->store("/aset/", 'public');
            $aset_baru->photo_url = $fd;
        }

        $aset_baru->save();


        return redirect()->to('/aset/create')->with('message', 'Berhasil menambahkan aset');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aset = Aset::findOrFail($id);

        return view('aset/show', compact('aset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aset = Aset::findOrFail($id);
        $kategori = Kategori::all();
        $satker = Satker::all();

        return view('aset/edit', compact('aset', 'kategori', 'satker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "nama_aset" => "required|min:4|max:255",
            "kode" => "required|min:3|max:255",
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function import()
    {
        return view("aset/import");
    }

    public function processImport(Request $request)
    {
        $request->validate([
            "aset-excel" => "required|file|mimes:xls,xlsx|max:10000"
        ]);

        \Excel::import(new AsetImports, $request->file('aset-excel'));

        return redirect()->to('/aset/import')->with('message', 'Data aset telah berhasil diimport');
    }
}
