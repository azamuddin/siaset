<?php

namespace App\Http\Controllers;

use App\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semua_satker = Satker::orderBy('id', 'DESC')->paginate(10);
        return view('satker/index', compact('semua_satker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satker/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $satker = new Satker;
        $satker->nama_satker = $request->nama_satker;
        $satker->save();

        return redirect("satker/create")
            ->with("pesan", "Berhasil menyimpan satker");
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
        $satker = Satker::findOrFail($id);

        return view('satker/edit', compact('satker'));
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
        $satker = Satker::findOrFail($id);
        $satker->nama_satker = $request->nama_satker;
        $satker->save();

        return redirect("satker/$id/edit")->with('pesan', 'Berhasil mengupdate satker');
    }

    public function delete($id)
    {
        $satker = Satker::findOrFail($id);

        return view('satker/delete', compact('satker'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satker = Satker::findOrFail($id);
        $satker->delete();

        return redirect("satker");
    }
}
