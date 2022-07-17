<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class OperatorController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Operator', 'operator', 'view');
    }

    public function det(Request $request)
    {
        $id_operator = $request->segment(4);

        $data = [
            'operator' => Operator::find($id_operator),
        ];

        return Template::load($this->session['roles'], 'Detail Operator', 'operator', 'det', $data);
    }

    public function get_data_dt()
    {
        $data = Operator::with(['toDinas', 'toUser'])->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_operator === null) {
                // tambah
                $id_users = get_acak_id(User::class, 'id_users');

                $user = new User();
                $user->id_users = $id_users;
                $user->nama     = $request->nama;
                $user->email    = $request->email;
                $user->username = $request->username;
                $user->password = Hash::make('12345678');
                $user->roles    = 'operator';
                $user->active   = 'y';
                $user->save();

                $operator = new Operator();
                $operator->id_users = $id_users;
                $operator->id_dinas = $request->id_dinas;
                $operator->kelamin  = $request->kelamin;
                $operator->by_users = $this->session['id_users'];
                $operator->save();
            }

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Proses!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }

    public function del(Request $request)
    {
        try {
            $operator = Operator::find($request->id);

            $user = User::find($operator->id_users);

            $user->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
