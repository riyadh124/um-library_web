<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Returns;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrow::with('user', 'book')->orderBy('created_at', 'desc');

    // Pencarian
    if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function ($query) use ($searchTerm) {
            $query->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->orWhereHas('book', function ($query) use ($searchTerm) {
                $query->where('judul_buku', 'like', "%$searchTerm%");
            });
        });
    }


    $borrows = $query->paginate(10);

    return view('dashboard.borrow.index', compact('borrows'));
    }


    public function getBorrowedBooksByUser(Request $request)
    {
        // Mendapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // Mengambil daftar buku yang sedang dipinjam oleh pengguna beserta data bukunya
        $borrowedBooks = Borrow::with('book')
            ->where('user_id', $userId)
            ->whereNotNull('borrowed_at')
            ->whereNull('returned_at')
            ->get();

        // Menghitung dan menambahkan denda keterlambatan untuk setiap entri pinjaman
        foreach ($borrowedBooks as $borrow) {
            // Menghitung selisih hari terlambat
            $borrowedDate = new \DateTime($borrow->borrowed_at);
            $returnedDate = new \DateTime();
            $difference = $returnedDate->diff($borrowedDate);
            $daysOverdue = $difference->days - 7;

            // Menghitung jumlah denda
            $fineAmount = $daysOverdue > 0 ? $daysOverdue * 2000 : 0;

            // Memperbarui entri pinjaman dengan tanggal pengembalian dan denda keterlambatan
            $borrow->overdue_fine = $fineAmount;
            $borrow->save();
        }

        // Mengembalikan daftar buku yang sedang dipinjam beserta data bukunya dalam bentuk JSON
        return response()->json(['status' => 'success', 'data' => $borrowedBooks], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);
    
        try {
            // Mengecek apakah pengguna telah melakukan kehadiran hari ini
            $today = now()->toDateString();
            $userAttendance = Attendance::where('user_id', $request->user_id)
                ->whereDate('attendance_date', $today)
                ->first();
    
            if (!$userAttendance) {
                return response()->json(['message' => 'Anda belum melakukan kehadiran hari ini.'], 400);
            }
    
            // Mengecek jumlah buku yang sedang dipinjam oleh pengguna
            $borrowedBooksCount = Borrow::where('user_id', $request->user_id)
                ->whereNull('returned_at')
                ->count();
    
            // Memeriksa apakah pengguna telah meminjam maksimum 3 buku
            if ($borrowedBooksCount >= 3) {
                return response()->json(['message' => 'Anda telah meminjam maksimum 3 buku.'], 400);
            }
    
            // Memeriksa apakah atribut tambahan pengguna tidak kosong atau null
            $user = User::findOrFail($request->user_id);
    
            if (empty($user->nim) || empty($user->ktm) || empty($user->no_telepon)) {
                return response()->json(['message' => 'Data pengguna tidak lengkap.'], 400);
            }
    
            // Mengecek status buku
            $book = Book::findOrFail($request->book_id);
    
            if ($book->status == 'Dipinjam') {
                // Mengembalikan response gagal jika status buku bukan "Tersedia"
                return response()->json(['message' => 'Buku tidak tersedia untuk dipinjam.'], 400);
            }
    
            // Membuat instance baru dari model Borrow
            $borrow = new Borrow();
    
            // Mengisi atribut-atribut pada model Borrow
            $borrow->user_id = $request->user_id;
            $borrow->book_id = $request->book_id;
            $borrow->borrowed_at = now(); // Tanggal peminjaman, bisa disesuaikan dengan waktu saat ini
            // $borrow->returned_at = null; // Tanggal pengembalian, akan diisi saat buku dikembalikan
            // $borrow->overdue_fine = 0; // Biaya keterlambatan, bisa diisi sesuai dengan kebijakan perpustakaan
    
            // Menyimpan data pinjaman ke dalam database
            $borrow->save();
    
            // Mengubah status buku menjadi "Dipinjam"
            $book->status = 'Dipinjam';
            $book->save();
    
            // Mengembalikan response yang sesuai
            return response()->json(['message' => 'Data peminjaman berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            // Mengembalikan response gagal jika terjadi kesalahan
            return response()->json(['message' => 'Gagal menyimpan data peminjaman.', 'error' => $e->getMessage()], 500);
        }
    }

    public function returnBook(Borrow $borrow)
    {
        // $request->validate([
        //     'borrow_id' => 'required|exists:borrows,id',
        // ]);

        try {
            // Mengambil data pinjaman

            $borrow = Borrow::findOrFail($borrow->id);

           
            // Memastikan bahwa buku telah dipinjam
            if ($borrow->returned_at !== null) {
                return redirect('/dashboard/borrow')->with('fail','Buku telah dikembalikan sebelumnya.');
            }

         // Menandai tanggal pengembalian
       
        
         // Menghitung denda jika buku dikembalikan terlambat
         $borrowed_at = new \DateTime($borrow->borrowed_at);
         $returned_at = new \DateTime();
         $difference = $returned_at->diff($borrowed_at);
         $days_overdue = $difference->days - 7; // Menghitung selisih hari terlambat
         $fine_amount = $days_overdue > 0 ? $days_overdue * 2000 : 0;
        
         $book = Book::findOrFail($borrow->book_id);

         // Mengubah status buku menjadi "Dipinjam"
         $book->status = 'Tersedia';
         $book->save();
         
         $borrow->returned_at = now();
         $borrow->overdue_fine = $fine_amount;
         $borrow->save();

            return redirect('/dashboard/borrow')->with('success','Book has been returned!');
        } catch (\Exception $e) {
            // Mengembalikan response gagal jika terjadi kesalahan
            return response()->json(['message' => 'Gagal mengembalikan buku.', 'error' => $e->getMessage()], 500);
        }
    }
}
