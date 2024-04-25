<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.user.index',[
            'users' => User::all()
           ]);
    }

    public function updateProfilePhoto(Request $request)
{
    try {
        // Validasi permintaan
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Anda dapat menyesuaikan validasi sesuai kebutuhan
        ]);

        // Dapatkan pengguna yang akan diperbarui
        $user = User::findOrFail($request->user_id);

        // Simpan foto profil baru
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatar', $avatarName); // Simpan foto ke penyimpanan yang diinginkan, misalnya penyimpanan publik
            $user->avatar = 'storage/avatar/' . $avatarName; // Simpan path foto ke database
            $user->save();

            // Kirim respons berhasil
            return response()->json(['message' => 'Profile photo updated successfully', 'user' => $user], 200);
        } else {
            // Kirim respons gagal jika foto tidak ditemukan
            return response()->json(['message' => 'Avatar file not found'], 400);
        }
    } catch (\Exception $e) {
        // Kirim respons gagal jika terjadi kesalahan
        return response()->json(['message' => 'Failed to update profile photo', 'error' => $e->getMessage()], 500);
    }
}
    
    public function confirmUser(Request $request, User $user)
    {

        // Konfirmasi akun pengguna
        $user->is_confirmed = true;
        $user->save();

        return redirect('/dashboard/user')->with('success','User has been confirmed!');    
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();

        // Simpan data ke dalam database
        User::create($data);

        return redirect('/dashboard/user')->with('success','New user has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/dashboard/user')->with('success','User has been deleted!');
    }
}
