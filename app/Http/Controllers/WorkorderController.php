<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkorderRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Models\DocumentationAfterWork;
use App\Models\DocumentationBeforeWork;
use App\Models\Workorder;
use App\Models\ListMaterial;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        // Jika status adalah "Ongoing", ambil data workorder tanpa memperhatikan user_id
        if ($status != "Ongoing") {
            $workorder = Workorder::where('status', $status)
                ->with('user','listMaterials.material', 'documentationBefore', 'documentationAfter')
                ->get();
        } else {
            // Jika bukan "Ongoing", gunakan ID pengguna seperti biasa
            $user_id = $request->user()->id;
        
            $workorder = Workorder::where('status', $status)
                ->where('user_id', $user_id)
                ->with('user','listMaterials.material', 'documentationBefore', 'documentationAfter')
                ->get();
        }
        
        return response()->json($workorder);
    }

    public function uploadImage(Request $request)
    {
        // Validasi request, pastikan file yang dikirim adalah gambar
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif', // Sesuaikan dengan kebutuhan Anda
        ]);

        if ($request->file('image')->isValid()) {
            // Simpan gambar ke storage atau folder tertentu
            $path = $request->file('image')->store('images', 'public'); // 'images' adalah nama folder penyimpanan

            // Mengembalikan path gambar untuk informasi selanjutnya atau respons yang sesuai
            return response()->json(['image_path' => $path]);
        } else {
            // Respons jika terjadi kesalahan saat menyimpan gambar
            return response()->json(['message' => 'Gagal menyimpan gambar'], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        
        // Ambil nilai status baru dari request
        $newStatus = $request->input('status');

        // Ambil ID pengguna yang melakukan aksi
        $userId = $request->user()->id;

        // Cari workorder beserta informasi user yang terkait
        $workorder = Workorder::find($id);

        if (!$workorder) {
            return response()->json(['message' => 'Workorder tidak ditemukan'], 404);
        }

        // Ubah status workorder
        $workorder->status = $newStatus;

        // Tambahkan ID pengguna ke dalam workorder
        $workorder->user_id = $userId;

        // Simpan perubahan
        $workorder->save();

        $workorder = Workorder::with('user','listMaterials.material','documentationBefore','documentationAfter')->find($id);

        return response()->json(['message' => 'Berhasil mengambil workorder', 'workorder' => $workorder]);
    }


    public function inputData(Request $request, $id)
    {
        $workorder = Workorder::find($id);

        if (!$workorder) {
            return response()->json(['message' => 'Workorder tidak ditemukan'], 404);
        }

        $documentation_before = $request->input('foto_sebelum_pekerjaan');

        foreach ($documentation_before as $doc_before) {
            $listDocBefore = new DocumentationBeforeWork();

            $listDocBefore->workorder_id = $id;
            $listDocBefore->image = $doc_before;
    
            $listDocBefore->save();
        }

        $list_materials = $request->input('list_material');

        foreach ($list_materials as $list_material) {
            // Membuat instance ListMaterial
            $listMaterial = new ListMaterial();
            // Isi kolom dengan nilai dari objek saat ini dalam iterasi
            $listMaterial->workorder_id = $id;
            $listMaterial->material_id = $list_material['id'];
            $listMaterial->count = $list_material['count'];
            $listMaterial->image = $list_material['image'];
        
            // Menyimpan data ke dalam database
            $listMaterial->save();
        }

        $documentation_after = $request->input('foto_setelah_pekerjaan');

        foreach ($documentation_after as $doc_after) {
            $listDocAfter = new DocumentationAfterWork();
            
            $listDocAfter->workorder_id = $id;
            $listDocAfter->image = $doc_after;
    
            $listDocAfter->save();
        }

        $keterangan_perbaikan = $request->input('keterangan_perbaikan');

        $workorder->keterangan_perbaikan = $keterangan_perbaikan;

        $workorder->status = "Done";

        $workorder->save();

        $workorder = Workorder::with('user','listMaterials.material','documentationBefore','documentationAfter')->find($id);

        return response()->json(['message' => 'Status workorder berhasil diubah', 'workorder' => $workorder]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkorderRequest $request)
    {
        $data = $request->all();

        // Simpan data ke dalam database
        $workorder = Workorder::create($data);

        return response()->json($workorder);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workorder $id)
    {
        $workorder = Workorder::find($id);
        return response()->json($workorder);
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
    public function update(UpdateWorkorderRequest $request, Workorder $id)
    {
        return response()->json(['message' => 'Workorder berhasil diperbarui', 'workorder' => $request]);

    //    // Mendapatkan data yang dikirim dari Flutter
    //    $dataFromFlutter = $request->all(); // Mendapatkan semua data dari request

    //    // Mengambil workorder berdasarkan ID yang dikirim dari Flutter
    //    $workorder = Workorder::findOrFail($id);

    //    // Lakukan update data workorder
    //    $workorder->update($dataFromFlutter);

       // Jika ingin memberikan respons ke aplikasi Flutter
    //    return response()->json(['message' => 'Workorder berhasil diperbarui', 'workorder' => $workorder]);
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workorder $id)
    {
        $workorder = Workorder::find($id);
        $workorder->delete();

        return response()->json('Workorder deleted successfully');
    }
}
