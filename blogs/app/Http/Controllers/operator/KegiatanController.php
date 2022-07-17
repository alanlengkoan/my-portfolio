<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KegiatanController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'operator'); 
    }
    
    public function index()
    {
        return Template::load($this->session['roles'], 'Kegiatan', 'kegiatan', 'view');
    }

    public function det(Request $request)
    {
        $id_kegiatan = $request->segment(4);

        $data = [
            'kegiatan' => Kegiatan::find($id_kegiatan),
        ];

        return Template::load($this->session['roles'], 'Detail Kegiatan', 'kegiatan', 'det', $data);
    }

    public function get(Request $request)
    {
        $response = Kegiatan::find($request->id);

        return response()->json($response);
    }

    public function get_all()
    {
        $get = Kegiatan::with(['toDinas'])->where('kegiatan.id_dinas', '=', $this->operator->id_dinas)->orderBy('id_kegiatan', 'desc')->get();

        $response = [];

        foreach ($get as $value) {
            $response[] = [
                'id'   => $value->id_kegiatan,
                'text' => $value->toDinas->nama . ' | ' . $value->nama,
            ];
        }

        return response()->json($response);
    }
    
    public function get_year()
    {
        $response = Kegiatan::select('thn_anggaran as id', 'thn_anggaran as text')->groupBy('thn_anggaran')->get();
        
        return response()->json($response);
    }

    public function get_data_dt()
    {
        $data = Kegiatan::with(['toDinas'])->where('kegiatan.id_dinas', '=', $this->operator->id_dinas)->orderBy('id_kegiatan', 'desc')->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_kegiatan === null) {
                $kegiatan = new Kegiatan();
            } else {
                $kegiatan = Kegiatan::find($request->id_kegiatan);
            }


            $kegiatan->id_dinas      = $this->operator->id_dinas;
            $kegiatan->nama          = $request->nama;
            $kegiatan->no_rek        = $request->no_rek;
            $kegiatan->thn_anggaran  = $request->thn_anggaran;
            $kegiatan->nilai_pagu    = remove_separator($request->nilai_pagu);
            $kegiatan->nilai_kontrak = remove_separator($request->nilai_kontrak);
            $kegiatan->by_users      = $this->session['id_users'];

            $kegiatan->save();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}