<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Models\Project;
use App\Models\ProjectPicture;
use App\Models\ProjectStack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // untuk deteksi session
        detect_role_session($this->session, $request->session()->has('roles'), 'admin');
    }

    public function index()
    {
        return Template::load($this->session['roles'], 'Project', 'project', 'view');
    }

    public function add()
    {
        return Template::load($this->session['roles'], 'Tambah Project', 'project', 'add');
    }

    public function upd($id)
    {
        $data = [
            'project'          => Project::find($id),
            'project_stack'    => ProjectStack::where('id_project', $id)->get(),
            'project_picture'  => ProjectPicture::where('id_project', $id)->get(),
        ];

        return Template::load($this->session['roles'], 'Ubah Project', 'project', 'upd', $data);
    }

    public function det($id)
    {
        $data = [
            'project'          => Project::find($id),
            'project_stack'    => ProjectStack::where('id_project', $id)->get(),
            'project_picture'  => ProjectPicture::where('id_project', $id)->get(),
        ];

        return Template::load($this->session['roles'], 'Detail Project', 'project', 'det', $data);
    }

    public function get_data_dt()
    {
        $data = Project::orderBy('id_project', 'desc')->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function save(Request $request)
    {
        try {
            if ($request->id_project === null) {
                $nama_gambar = add_picture($request->gambar);

                // project
                $project = new Project();
                $project->judul       = $request->judul;
                $project->deskripsi   = $request->deskripsi;
                $project->link_demo   = $request->link_demo;
                $project->link_github = $request->link_github;
                $project->gambar      = $nama_gambar;
                $project->by_users    = $this->session['id_users'];
                $project->save();

                // project stack
                $stack = $request->id_stack;
                for ($i = 0; $i < count($stack); $i++) {
                    $project_stack[] = [
                        'id_project' => $project->id_project,
                        'id_stack'   => $stack[$i],
                        'by_users'   => $this->session['id_users'],
                    ];
                }
                ProjectStack::insert($project_stack);

                // project picture
                $picture = $request->picture;
                for ($i = 0; $i < count($picture); $i++) {
                    $nama_foto[$i] = add_picture($request->picture[$i]);

                    $project_picture[] = [
                        'id_project' => $project->id_project,
                        'picture'    => $nama_foto[$i],
                        'by_users'   => $this->session['id_users'],
                    ];
                }
                ProjectPicture::insert($project_picture);

                $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Simpan!', 'type' => 'success', 'button' => 'Ok!'];
            } else {
            }
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return Response::json($response);
    }

    public function del(Request $request)
    {
        try {
            $project = Project::find($request->id);

            del_picture($project->gambar);

            $project->delete();

            $response = ['title' => 'Berhasil!', 'text' => 'Data Sukses di Hapus!', 'type' => 'success', 'button' => 'Ok!'];
        } catch (\Exception $e) {
            $response = ['title' => 'Gagal!', 'text' => 'Data Gagal di Proses!', 'type' => 'error', 'button' => 'Ok!'];
        }

        return response()->json($response);
    }
}
