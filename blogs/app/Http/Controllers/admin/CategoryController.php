<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Category', 'category', 'view');
    }

    public function get(Request $request)
    {
        $response = Category::find($request->id);

        return response()->json($response);
    }

    public function get_all()
    {
        $response = Category::select('id_category AS id', 'nama AS text')->orderBy('id_category', 'desc')->get();

        return response()->json($response);
    }

    public function get_data_dt()
    {
        $data = Category::orderBy('id_category', 'desc')->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            Category::updateOrCreate(
                [
                    'id_category' => $request->id_category,
                ],
                [
                    'nama'     => $request->nama,
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
            $category = Category::find($request->id);

            $category->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
