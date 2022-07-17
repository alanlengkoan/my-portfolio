<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\KegiatanBeritaAcara;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class KegiatanBeritaAcaraController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }
    
    public function index()
    {
        return Template::load($this->session['roles'], 'Berita Acara Pemeriksaan', 'berita_acara', 'view');
    }

    public function get_data_dt(Request $request)
    {
        $query = KegiatanBeritaAcara::query();
        $query->with(['toKegiatan.toDinas']);
        $query->orderBy('id_kegiatan_berita_acara', 'desc');
        if ($request->id_kegiatan) {
            $query->where('kegiatan_berita_acara.id_kegiatan', '=', $request->id_kegiatan);
        }
        
        $data = $query->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
    }

    public function get(Request $request)
    {
        $response = KegiatanBeritaAcara::find($request->id);

        return response()->json($response);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_kegiatan_berita_acara === null) {
                $kegiatan_berita_acara = new KegiatanBeritaAcara();

                $nama_gambar = add_picture($request->gambar);

                $kegiatan_berita_acara->id_kegiatan = $request->id_kegiatan;
                $kegiatan_berita_acara->no_surat    = $request->no_surat;
                $kegiatan_berita_acara->gambar      = $nama_gambar;
                $kegiatan_berita_acara->by_users    = $this->session['id_users'];
            } else {
                $kegiatan_berita_acara = KegiatanBeritaAcara::find($request->id_kegiatan_berita_acara);

                if (isset($request->change_picture) && $request->change_picture === 'on') {
                    $nama_gambar = upd_picture($request->gambar, $kegiatan_berita_acara->gambar);

                    $kegiatan_berita_acara->gambar = $nama_gambar;
                }

                $kegiatan_berita_acara->id_kegiatan = $request->id_kegiatan;
                $kegiatan_berita_acara->no_surat    = $request->no_surat;
                $kegiatan_berita_acara->by_users    = $this->session['id_users'];
            }

            $kegiatan_berita_acara->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        $kegiatan_berita_acara = KegiatanBeritaAcara::find($request->id);

        del_picture($kegiatan_berita_acara->gambar);

        $kegiatan_berita_acara->delete();

        $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];

        return response()->json($response);
    }
}