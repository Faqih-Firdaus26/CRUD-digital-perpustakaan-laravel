<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuGalleryRequest;
use App\Models\Buku;
use App\Models\BukuGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BukuGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buku $buku)
    {
        if(request()->ajax())
        {
            $query = BukuGallery::query();

            return DataTables::of($query)
            ->addColumn('action', function ($buku){
                return '
                    <form class="inline-block" action="'. route('dashboard.gallery.destroy', $buku->id). ' " method="POST"> 
                        <button class="bg-red-500 text-white rounded-md px-2 py-1 m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                      </svg>
                        </button>
                        '. method_field('delete'). csrf_field().'
                    </form>
                ';
            })
            ->editColumn('url', function($buku){
                return '<img style="max-width: 150px" src="'. Storage::url($buku->url) .' "/>';
            })
            ->editColumn('is_featured', function($buku){
                return $buku->is_featured ? 'yes' : 'no';
            })
            ->rawColumns(['action','url'])
            ->make();
        }

        return view('pages.dashboard.gallery.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Buku $buku)
    {
        return view('pages.dashboard.gallery.create', compact('buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BukuGalleryRequest $request, Buku $buku)
    {
        $files = $request->file('files');

        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                // Generate a unique filename for each file
                $filename = uniqid() . '_' . $file->getClientOriginalName();

                // Store the file in the "gallery" directory without the "public/" prefix
                $path = $file->storeAs('gallery', $filename, 'public');

                BukuGallery::create([
                    'bukus_id' => $buku->id,
                    'url' => $path
                ]);
            }
        }

        // Alert::success('Sukses', 'Gambar Berhasil Di Tambahkan');
        return redirect()->route('dashboard.buku.gallery.index', $buku->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(BukuGallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('dashboard.buku.gallery.index', $gallery->bukus_id);
    }
}