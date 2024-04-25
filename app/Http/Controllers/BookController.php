<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\Http\Controllers\Storage;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::query()
            ->where('judul_buku', 'LIKE', '%' . $search . '%')
            ->orWhere('pengarang', 'LIKE', '%' . $search . '%')
            ->orWhere('penerbit', 'LIKE', '%' . $search . '%')
            ->orWhere('tahun_terbit', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->orWhere('kode_buku', 'LIKE', '%' . $search . '%')
            ->get();
    
        $barcodes = [];
    
        foreach ($books as $book) {
            $barcode = (new DNS1D())->getBarcodeHTML($book->kode_buku, "C128");
            $barcodes[$book->id] = $barcode;
        }
    
        return view('dashboard.book.index', [
            'books' => $books,
            'barcodes' => $barcodes,
        ]);
    }
    

    public function findByKodeBuku($kodeBuku)
    {
        $book = Book::where('kode_buku', $kodeBuku)->first();

        if ($book) {
            return response()->json(['status' => 'success', 'data' => $book], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
        }
    }

    public function generateBarcode($kodeBuku)
    {
        // Generate barcode
        $barcode = new DNS1D();
        $barcode->setStorPath(__DIR__ . "/cache/");
        return $barcode->getBarcodeHTML($kodeBuku, "C128");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'kode_buku' => 'required|max:255',
            'penerbit' => 'required|max:255',
            'tahun_terbit' => 'required|date_format:Y', // Format tahun terbit sebagai tahun (contoh: 2022)
            'status' => 'required|in:Tersedia,Dipinjam,Tidak Tersedia',
            // 'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Simpan cover buku
    
        // Simpan buku baru
        $book = new Book();
        $book->judul_buku = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->kode_buku = $request->kode_buku;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->status = $request->status;

       
        if ($request->hasFile('cover')) {    
            // Store the new cover image
            $coverPath = $request->file('cover')->store('public/images');
            $book->cover = str_replace('public/', '', $coverPath);
        }
        
        $book->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('dashboard.book.index')->with('success', 'Buku berhasil ditambahkan!');
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
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('edit', compact('book'));
    }
    
    // Untuk update data
    public function update(Request $request, $id)
    {
        // dd($request);
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'kode_buku' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'status' => 'required',
            // 'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Menambahkan validasi untuk cover (opsional)
        ]);
    
        // Temukan buku berdasarkan ID yang dikirim dari form
        $book = Book::findOrFail($request->book_id);
    
        // Update atribut buku dengan data baru
        $book->judul_buku = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->kode_buku = $request->kode_buku;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->status = $request->status;
       
        if ($request->hasFile('cover')) {    
            // Store the new cover image
            $coverPath = $request->file('cover')->store('public/images');
            $book->cover = str_replace('public/', '', $coverPath);
        }

        $book->save();

        
        return redirect()->route('dashboard.book.index')->with('success', 'Buku berhasil diperbarui!');   
    }
    
    // Untuk menghapus data
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('dashboard.book.index')->with('success', 'Buku berhasil dihapus!');
    }
}
