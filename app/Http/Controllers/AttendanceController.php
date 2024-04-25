<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Milon\Barcode\DNS2D;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user')->orderBy('created_at', 'desc');

        // Pencarian
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            });
        }
    
        $attendances = $query->paginate(10);

        // Mendapatkan tanggal hari ini dalam format yang diinginkan
        $today = date('Y-m-d');

        // Membuat string barcode berdasarkan tanggal hari ini
        $barcode = "Attendance-" . $today;

        // Membuat barcode dengan library milon/barcode
        $barcodeGenerator = new DNS2D();
        $barcodeData = $barcodeGenerator->getBarcodeHTML($barcode,  'QRCODE');
    
        return view('dashboard.attendance.index', compact('attendances','barcodeData'));
    }

    public function store(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barcode' => 'required|string',
        ]);
    
        $expectedBarcode = "Attendance-" . date('Y-m-d');
    
        // Memeriksa apakah barcode sesuai dengan format yang diharapkan
        if ($request->barcode !== $expectedBarcode) {
            // Jika tidak sesuai, kirim respons API gagal
            return response()->json(['message' => 'Invalid barcode'], 400);
        }
    
        // Memeriksa apakah pengguna telah melakukan kehadiran hari ini
        $existingAttendance = Attendance::where('user_id', $request->user_id)
            ->whereDate('attendance_date', now()->toDateString())
            ->exists();
    
        if ($existingAttendance) {
            // Jika pengguna telah melakukan kehadiran hari ini, kirim respons API gagal
            return response()->json(['message' => 'Anda sudah absensi hari ini'], 400);
        }
    
        // Simpan data hadir
        $attendance = new Attendance();
        $attendance->user_id = $request->user_id;
        $attendance->barcode = $request->barcode;
        $attendance->attendance_date = now();
        $attendance->save();
    
        // Kirim respons API
        return response()->json(['message' => 'Absensi berhasil'], 200);
    }
}
