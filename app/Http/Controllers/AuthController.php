<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return view('login.index',[
            "title" =>  'login',
        ]);
    }

    public function show(Request $request)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::find($request->user_id);

        // Jika pengguna tidak ditemukan, kirim respons 404
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Kirim respons dengan data pengguna
        return response()->json(['user' => $user]);
    }

    public function update(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nim' => 'nullable|string|max:255',
            'ktm' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        // Jika validasi gagal, kirim respons error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ambil ID pengguna dari request
        $userId = $request->user()->id;

        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Perbarui data pengguna
        $user->update($request->only(['nim', 'ktm', 'no_telepon']));

        // Kirim respons sukses
        return response()->json(['message' => 'User data updated successfully']);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if ($user->role !== 'Admin') {
                Auth::logout();
                return back()->with('loginError','Only Admins are allowed to login!');
            }
    
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
    
        return back()->with('loginError','Login failed!');
    }

    public function logout(Request $request){
      
      Auth::logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect('/');

    }

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            // Cari pengguna berdasarkan email
            $user = User::where('email', $request->email)->first();

            // Periksa apakah pengguna ditemukan dan apakah akunnya sudah dikonfirmasi
            if(!$user || !Hash::check($request->password, $user->password) || !$user->is_confirmed){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Kata Sandi tidak sesuai dengan catatan kami atau akun Anda belum terverifikasi, silahkan hubungi petugas perpustakaan terlebih dahulu.',
                ], 401);
            }
            
            if ($request->has("fcm_token")) {    
                $user->fcm_token = $request->fcm_token;
                $user->save();
            }
    
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
