<?php

namespace App\Http\Controllers\operator;

use App\Exports\KegiatanExportAllView;
use App\Exports\KegiatanExportDetView;
use App\Http\Controllers\Controller;
use App\Libraries\Pdf;
use App\Libraries\Template;
use App\Models\Dinas;
use App\Models\Kegiatan;
use App\Models\KegiatanBeritaAcara;
use App\Models\KegiatanPencairanDana;
use App\Models\Ttd;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LaporanController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'operator');
    }

    public function kegiatan()
    {
        return Template::load($this->session['roles'], 'Laporan Kegiatan', 'laporan/kegiatan', 'view');
    }

    public function kegiatan_print_filter(Request $request)
    {
        $query = Kegiatan::query();
        $query->with(['toDinas']);
        $query->orderBy('id_kegiatan', 'desc');
        $query->where('kegiatan.id_dinas', '=', $this->operator->id_dinas);
        if ($request->tahun) {
            $query->where('kegiatan.thn_anggaran', '=', $request->tahun);
        }

        $data = $query->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function kegiatan_print_all(Request $request)
    {
        // dinas
        $qry_dinas = Dinas::query();
        $qry_dinas->select('dinas.id_dinas', 'dinas.nama');
        $qry_dinas->where('dinas.id_dinas', '=', $this->operator->id_dinas);
        $dinas = $qry_dinas->get();

        $result = [];
        foreach ($dinas as $val_dinas) {
            // kegiatan
            $qry_kegiatan = Kegiatan::query();
            $qry_kegiatan->select('kegiatan.id_kegiatan', 'kegiatan.id_dinas', 'kegiatan.nama', 'kegiatan.no_rek', 'kegiatan.thn_anggaran', 'kegiatan.nilai_pagu', 'kegiatan.nilai_kontrak');
            $qry_kegiatan->where('kegiatan.id_dinas', '=', $val_dinas->id_dinas);
            if ($request->q_tahun) {
                $qry_kegiatan->where('kegiatan.thn_anggaran', '=', $request->q_tahun);
            }
            $kegiatan = $qry_kegiatan->get();

            $res_kegiatan = [];
            foreach ($kegiatan as $key_kegiatan => $val_kegiatan) {
                // pencairan dana
                $qry_pencairan_dana = KegiatanPencairanDana::query();
                $qry_pencairan_dana->select('kegiatan_pencairan_dana.id_kegiatan_pencairan_dana', 'kegiatan_pencairan_dana.id_kegiatan', 'kegiatan_pencairan_dana.no_surat', 'kegiatan_pencairan_dana.tgl_surat', 'kegiatan_pencairan_dana.nilai');
                $qry_pencairan_dana->where('kegiatan_pencairan_dana.id_kegiatan', '=', $val_kegiatan->id_kegiatan);
                $pencairan_dana = $qry_pencairan_dana->get();

                foreach ($pencairan_dana as $key_pencairan_dana => $val_pencairan_dana) {
                    $res_pencairan_dana[$val_pencairan_dana->id_kegiatan][] = [
                        'id_kegiatan_pencairan_dana' => $val_pencairan_dana->id_kegiatan_pencairan_dana,
                        'no_surat'                   => $val_pencairan_dana->no_surat,
                        'tgl_surat'                  => $val_pencairan_dana->tgl_surat,
                        'nilai'                      => $val_pencairan_dana->nilai,
                    ];
                }

                $res_kegiatan[$val_kegiatan->id_dinas][] = [
                    'id_kegiatan'    => $val_kegiatan->id_kegiatan,
                    'id_dinas'       => $val_kegiatan->id_dinas,
                    'nama'           => $val_kegiatan->nama,
                    'no_rek'         => $val_kegiatan->no_rek,
                    'thn_anggaran'   => $val_kegiatan->thn_anggaran,
                    'nilai_pagu'     => $val_kegiatan->nilai_pagu,
                    'nilai_kontrak'  => $val_kegiatan->nilai_kontrak,
                    'pencairan_dana' => $res_pencairan_dana[$val_kegiatan->id_kegiatan] ?? [],
                ];
            }

            $result[] = [
                'id_dinas' => $val_dinas->id_dinas,
                'nama'     => $val_dinas->nama,
                'kegiatan' => $res_kegiatan[$val_dinas->id_dinas] ?? [],
            ];
        }

        $ttd   = Ttd::where('id_ttd', '=', $request->id_ttd)->first();
        $dinas = Dinas::where('id_dinas', '=', $this->operator->id_dinas)->first();

        $data = [
            'title'      => 'Kegiatan',
            'dinas'      => strtoupper($dinas->nama),
            'data'       => $result,
            'ttd'        => $ttd,
            'tgl_dibuat' => date('Y-m-d'),
        ];

        if ($request->tipe_file == 'pdf') {
            Pdf::printPdf('kegiatan', 'admin.laporan.kegiatan.print_all_pdf', 'legal', 'landscape', $data);
        } else {
            return Excel::download(new KegiatanExportAllView($data), 'laporan kegiatan.xlsx');
        }
    }

    public function kegiatan_print_det(Request $request)
    {
        $id_kegiatan = $request->q_id_kegiatan;

        $kegiatan = Kegiatan::select('kegiatan.*', 'dinas.nama as kantor_dinas')
            ->join('dinas', 'dinas.id_dinas', '=', 'kegiatan.id_dinas')
            ->where('kegiatan.id_kegiatan', '=', $id_kegiatan)
            ->first();

        $total = KegiatanPencairanDana::join('kegiatan', 'kegiatan.id_kegiatan', '=', 'kegiatan_pencairan_dana.id_kegiatan')
            ->where('kegiatan_pencairan_dana.id_kegiatan', $id_kegiatan)
            ->sum('kegiatan_pencairan_dana.nilai');

        $sisa     = ($kegiatan->nilai_pagu - (int) $total);
        $terpakai = ($kegiatan->nilai_pagu - (int) $sisa);
        $ttd      = Ttd::where('id_ttd', '=', $request->id_ttd)->first();

        $data = [
            'title'          => 'Detail Kegiatan',
            'sisa'           => $sisa,
            'terpakai'       => $terpakai,
            'kegiatan'       => $kegiatan,
            'ttd'            => $ttd,
            'tgl_dibuat'     => date('Y-m-d'),
            'pencairan_dana' => KegiatanPencairanDana::where('id_kegiatan', $id_kegiatan)->orderBy('id_kegiatan_pencairan_dana', 'desc')->get(),
            'berita_acara'   => KegiatanBeritaAcara::where('id_kegiatan', $id_kegiatan)->orderBy('id_kegiatan_berita_acara', 'desc')->get(),
        ];

        if ($request->tipe_file == 'pdf') {
            Pdf::printPdf('kegiatan', 'admin.laporan.kegiatan.print_det_pdf', '', '', $data);
        } else {
            return Excel::download(new KegiatanExportDetView($data), 'laporan detail kegiatan.xlsx');
        }
    }
}
