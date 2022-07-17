<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Dinas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DinasController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }
    
    public function index()
    {
        return Template::load($this->session['roles'], 'Dinas', 'dinas', 'view');
    }

    public function get(Request $request)
    {
        $response = Dinas::find($request->id);

        return response()->json($response);
    }

    public function get_all()
    {
        $response = Dinas::select('id_dinas AS id', 'nama AS text')->orderBy('id_dinas', 'desc')->get();

        return response()->json($response);
    }

    public function get_data_dt()
    {
        $data = Dinas::orderBy('id_dinas', 'desc')->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_dinas === null) {
                $dinas = new Dinas();

                $dinas->nama     = $request->nama;
                $dinas->email    = $request->email;
                $dinas->telepon  = $request->telepon;
                $dinas->alamat   = $request->alamat;
                $dinas->fax      = $request->fax;
                $dinas->website  = $request->website;
                $dinas->by_users = $this->session['id_users'];
            } else {
                $dinas = Dinas::find($request->id_dinas);

                $dinas->nama     = $request->nama;
                $dinas->email    = $request->email;
                $dinas->telepon  = $request->telepon;
                $dinas->alamat   = $request->alamat;
                $dinas->fax      = $request->fax;
                $dinas->website  = $request->website;
                $dinas->by_users = $this->session['id_users'];
            }

            $dinas->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        try {
            $dinas = Dinas::find($request->id);

            $dinas->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
