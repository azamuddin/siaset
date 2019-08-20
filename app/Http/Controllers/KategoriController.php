<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('kelola-kategori');
        $semua_kategori = Kategori::orderBy('id', 'DESC')->paginate(5);
        return view('kategori/index', compact('semua_kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori_baru = new Kategori;
        $kategori_baru->nama_kategori = $request->nama_kategori;

        $kategori_baru->save();

        return redirect("kategori/create")
            ->with("pesan", "Berhasil menyimpan kategori");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori/edit', compact('kategori'));
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
        $kategori_untuk_diupdate = Kategori::findOrFail($id);
        $kategori_untuk_diupdate->nama_kategori = $request->nama_kategori;
        $kategori_untuk_diupdate->save();

        return redirect("kategori/$id/edit")->with('pesan', 'Berhasil mengupdate kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return redirect("kategori");
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori/delete', compact('kategori'));
    }
}
