<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Stack;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StackController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Stack', 'stack', 'view');
    }

    public function get(Request $request)
    {
        $response = Stack::find($request->id);

        return response()->json($response);
    }

    public function get_all()
    {
        $response = Stack::select('id_stack AS id', 'id_stack AS value', 'nama AS label')->orderBy('id_stack', 'desc')->get();

        return response()->json($response);
    }

    public function get_data_dt()
    {
        $data = Stack::orderBy('id_stack', 'desc')->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            Stack::updateOrCreate(
                [
                    'id_stack' => $request->id_stack,
                ],
                [
                    'nama'     => $request->nama,
                    'icon'     => $request->icon,
                    'by_users' => $this->session['id_users'],
                ]
            );

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        try {
            $stack = Stack::find($request->id);

            $stack->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
