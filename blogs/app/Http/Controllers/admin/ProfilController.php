<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }
    
    public function index()
    {
        $data = [
            'user' => User::find($this->session['id_users']),
        ];
        return Template::load($this->session['roles'], 'Profil', 'profil', 'view', $data);
    }

    public function save_picture(Request $request)
    {
        try {
            $user = User::find($this->session['id_users']);

            // hapus foto
            del_picture($user->foto);

            // nama foto
            $nama_foto = generate_random_name_file($request->i_foto);

            // upload foto
            $request->i_foto->move(upload_path('picture'), $nama_foto);

            $user->foto = $nama_foto;

            $request->session()->put('foto', $nama_foto);

            $user->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Simpan!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function save_account(Request $request)
    {
        try {
            $user = User::find($this->session['id_users']);

            $user->nama     = $request->i_nama;
            $user->email    = $request->i_email;
            $user->username = $request->i_username;

            $request->session()->put('nama', $request->i_nama);

            $user->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Simpan!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function save_security(Request $request)
    {
        $user = User::find($this->session['id_users']);

        if (Hash::check($request->i_pass_lama, $user->password)) {
            if ($request->i_pass_baru === $request->i_pass_baru_lagi) {
                try {
                    $user->password = Hash::make($request->i_pass_baru);
                    $user->save();

                    $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Simpan!', 'type' => 'success', 'button' => 'Ok!'];
                } catch (\Exception $e) {
                    $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Simpan!', 'type' => 'error', 'button' => 'Ok!'];
                }
            } else {
                $response = ['title' => 'Gagal!', 'text' => 'Password baru dan konfirmasi password baru tidak sama!', 'type' => 'error', 'button' => 'Ok!'];
            }
        } else {
            $response = ['title' => 'Gagal!', 'text' => 'Password lama yang Anda masukkan tidak sama!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
