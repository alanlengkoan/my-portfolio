<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Ttd;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TtdController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'operator');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Tanda Tangan', 'ttd', 'view');
    }

    public function get(Request $request)
    {
        $response = Ttd::find($request->id);

        return response()->json($response);
    }

    public function get_all()
    {
        $get = Ttd::with(['toDinas'])->where('ttd.id_dinas', '=', $this->operator->id_dinas)->orderBy('id_ttd', 'desc')->get();

        $response = [];

        foreach ($get as $value) {
            $response[] = [
                'id'   => $value->id_ttd,
                'text' => $value->toDinas->nama . ' | ' . $value->nama,
            ];
        }

        return response()->json($response);
    }

    public function get_data_dt()
    {
        $data = Ttd::with(['toDinas'])->where('ttd.id_dinas', '=', $this->operator->id_dinas)->orderBy('id_ttd', 'desc')->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_ttd === null) {
                $ttd = new Ttd();

                $ttd->id_dinas = $this->operator->id_dinas;
                $ttd->nip      = $request->nip;
                $ttd->nama     = $request->nama;
                $ttd->jabatan  = $request->jabatan;
                $ttd->by_users = $this->session['id_users'];
            } else {
                $ttd = Ttd::find($request->id_ttd);

                $ttd->id_dinas = $this->operator->id_dinas;
                $ttd->nip      = $request->nip;
                $ttd->nama     = $request->nama;
                $ttd->jabatan  = $request->jabatan;
                $ttd->by_users = $this->session['id_users'];
            }

            $ttd->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        try {
            $jabatan = Ttd::find($request->id);

            $jabatan->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
