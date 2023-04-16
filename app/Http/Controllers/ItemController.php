<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = DB::table('items')->get();
        return view('items.index',['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $namaGambar = uniqid().'.'.$request->file('gambar')->extension();
        $request->merge(['gambar' => $namaGambar]);
        $request->merge(['tanggal_post' => now()]);
        $request->file('gambar')->storeAs(
            'gambar', $namaGambar
        );

        Item::create($request->post());
        return redirect()->route('items.index')->with('success','Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $item= DB::table('items')->find($id);
        return view('items.detail',['item'=>$item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
        $item= DB::table('items')->find($id);
        $delete = DB::table('items')->where('id','=',$id)->delete();
        $delete;
        Storage::delete('gambar/'.$item->gambar);
        return redirect()->route('items.index')->with('success','Barang Berhasil dihapus.');
    }
}
