<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\KegiatanPencairanDana;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class KegiatanPencairanDanaController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Pencairan Dana', 'pencairan_dana', 'view');
    }

    public function get_data_dt(Request $request)
    {
        $query = KegiatanPencairanDana::query();
        $query->with(['toKegiatan.toDinas']);
        $query->orderBy('id_kegiatan_pencairan_dana', 'desc');
        if ($request->id_kegiatan) {
            $query->where('kegiatan_pencairan_dana.id_kegiatan', '=', $request->id_kegiatan);
        }

        $data = $query->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
    }

    public function get(Request $request)
    {
        $response = KegiatanPencairanDana::find($request->id);

        return response()->json($response);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_kegiatan_pencairan_dana === null) {
                $kegiatan_pencairan_dana = new KegiatanPencairanDana();

                $nama_gambar = add_picture($request->gambar);

                $kegiatan_pencairan_dana->id_kegiatan = $request->id_kegiatan;
                $kegiatan_pencairan_dana->no_surat    = $request->no_surat;
                $kegiatan_pencairan_dana->tgl_surat   = $request->tgl_surat;
                $kegiatan_pencairan_dana->nilai       = remove_separator($request->nilai);
                $kegiatan_pencairan_dana->gambar      = $nama_gambar;
                $kegiatan_pencairan_dana->by_users    = $this->session['id_users'];
            } else {
                $kegiatan_pencairan_dana = KegiatanPencairanDana::find($request->id_kegiatan_pencairan_dana);

                if (isset($request->change_picture) && $request->change_picture === 'on') {
                    $nama_gambar = upd_picture($request->gambar, $kegiatan_pencairan_dana->gambar);

                    $kegiatan_pencairan_dana->gambar = $nama_gambar;
                }

                $kegiatan_pencairan_dana->id_kegiatan = $request->id_kegiatan;
                $kegiatan_pencairan_dana->no_surat    = $request->no_surat;
                $kegiatan_pencairan_dana->tgl_surat   = $request->tgl_surat;
                $kegiatan_pencairan_dana->nilai       = remove_separator($request->nilai);
                $kegiatan_pencairan_dana->by_users    = $this->session['id_users'];
            }

            $kegiatan_pencairan_dana->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        $kegiatan_pencairan_dana = KegiatanPencairanDana::find($request->id);

        del_picture($kegiatan_pencairan_dana->gambar);

        $kegiatan_pencairan_dana->delete();

        $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];

        return response()->json($response);
    }
}
