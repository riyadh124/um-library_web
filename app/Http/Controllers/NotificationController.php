<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendNotification($id)
    {
        try {
            $borrow = Borrow::findOrFail($id);
    
            // Periksa apakah pengguna telah dikembalikan
            if (!is_null($borrow->returned_at)) {
                return response()->json(['message' => 'Buku telah dikembalikan.'], 400);
            }

            $borrowed_at = new \DateTime($borrow->borrowed_at);
            $returned_at = new \DateTime();
            $difference = $returned_at->diff($borrowed_at);
            $days_overdue = $difference->days - 7; // Menghitung selisih hari terlambat
            $fine_amount = $days_overdue > 0 ? $days_overdue * 2000 : 0;
         
            $borrow->overdue_fine = $fine_amount;
   
            $book = Book::findOrFail($borrow->book_id);

            // Mengubah status buku menjadi "Dipinjam"
   
            // Kirim notifikasi ke pengguna
            $user = $borrow->user;
            $fcmToken = $user->fcm_token;
            $title = "Perpustakaan Universitas Mulia";
            $body = "Denda buku '$book->judul_buku' anda sebesar Rp. $fine_amount, Harap kembalikan buku perpustakaan";
    
            $message = CloudMessage::fromArray([
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body
                ],
            ]);
    
            $firebase = app('firebase.messaging');
            $firebase->send($message);
    
            return redirect('/dashboard/borrow')->with('success','Notifikasi berhasil dikirim!');
    
        } catch (\Exception $e) {
            return redirect('/dashboard/borrow')->with('success','Notifikasi gagal dikirim!');
        }
    }
}

