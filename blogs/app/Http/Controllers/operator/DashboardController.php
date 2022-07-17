<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Kegiatan;
use App\Models\KegiatanPencairanDana;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'operator');
    }

    public function index()
    {
        $total_pagu     = Kegiatan::where('kegiatan.id_dinas', '=', $this->operator->id_dinas)->sum('nilai_pagu');
        $total_kontrak  = Kegiatan::where('kegiatan.id_dinas', '=', $this->operator->id_dinas)->sum('nilai_kontrak');
        $total_terpakai = KegiatanPencairanDana::join('kegiatan', 'kegiatan.id_kegiatan', '=', 'kegiatan_pencairan_dana.id_kegiatan')->where('kegiatan.id_dinas', '=', $this->operator->id_dinas)->sum('kegiatan_pencairan_dana.nilai');
        $total_sisa     = $total_pagu - $total_terpakai;

        $data = [
            'nama'           => $this->session['nama'],
            'total_pagu'     => $total_pagu,
            'total_kontrak'  => $total_kontrak,
            'total_terpakai' => $total_terpakai,
            'total_sisa'     => $total_sisa,
        ];

        return Template::load($this->session['roles'], 'Dashboard', 'dashboard', 'view', $data);
    }
}
