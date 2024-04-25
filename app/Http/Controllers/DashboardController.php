<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Workorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil total user
        $totalUsers = User::count();

        // Mengambil total buku
        $totalBooks = Book::count();

        // Mengambil total borrow yang belum dikembalikan
        $totalBorrowsNotReturned = Borrow::whereNull('returned_at')->count();

        // Mengambil total borrow yang sudah dikembalikan
        $totalBorrowsReturned = Borrow::whereNotNull('returned_at')->count();

        // Mengirim data ke view
        return view('dashboard.index', compact('totalUsers', 'totalBooks', 'totalBorrowsNotReturned', 'totalBorrowsReturned'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workorder $workorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workorder $workorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workorder $workorder)
    {
        
    }
}
