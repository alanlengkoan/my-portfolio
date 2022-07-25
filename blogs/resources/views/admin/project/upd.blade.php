<!-- begin:: base -->
@extends('admin/base')
<!-- end:: base -->

<!-- begin:: css local -->
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset_admin('my_assets/datatables/1.11.3/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset_admin('my_assets/datatables-responsive/2.2.9/css/responsive.dataTables.min.css') }}" />
@endsection
<!-- end:: css local -->

<!-- begin:: content -->
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- begin:: breadcumb -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $title }}</h4>
                    <div class="page-title-right">
                        {{ Breadcrumbs::render('admin.project.upd', $project) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: breadcumb -->
        <!-- begin:: body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <form id="form-add-upd" action="{{ route('admin.project.save') }}" method="POST" enctype="multipart/form-data">
                                <!-- begin:: id -->
                                <input type="hidden" name="id_project" id="id_project" value="{{ $project->id_project }}" />
                                <!-- end:: id -->

                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-2 col-form-label">Judul&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" id="judul" class="form-control" value="{{ $project->judul }}" placeholder="Enter judul" />
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Enter deskripsi">{{ $project->deskripsi }}</textarea>
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="link_demo" class="col-sm-2 col-form-label">Link Demo&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="link_demo" id="link_demo" class="form-control" value="{{ $project->link_demo }}" placeholder="Enter demo link" />
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Link Github&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="link_github" id="link_github" class="form-control" value="{{ $project->link_github }}" placeholder="Enter github link" />
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="id_stack" class="col-sm-2 col-form-label">Stack&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_stack[]" id="id_stack" multiple>
                                            <option value="" disabled>Select stack</option>
                                        </select>
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Gambar&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="gambar" id="gambar" class="form-control" />
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Detail Gambar&nbsp;*</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="picture[]" id="picture" class="form-control" multiple />
                                        <span class="errorInput"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mt-1 text-center">
                                        <div class="preview-image row"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <a href="{{ route('admin.project') }}" id="cancel" class="btn btn-danger btn-sm">
                                            <i class="fa fa-times"></i>&nbsp;Cancel
                                        </a>
                                        <button type="submit" id="save" class="btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: body -->
    </div>
</div>
@endsection
<!-- end:: content -->

<!-- begin:: js local -->
@section('js')
<script type="text/javascript" src="{{ asset_admin('my_assets/datatables/1.11.3/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_admin('my_assets/datatables/1.11.3/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_admin('my_assets/datatables-responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_admin('my_assets/parsley/2.9.2/parsley.js') }}"></script>

<script>
    let untukMultipleSelectStack = function() {
        $.get("{{ route('admin.stack.get_all') }}", function(response) {
            new Choices('#id_stack', {
                removeItemButton: true,
                removeItems: true,
                duplicateItems: false,
                choices: response
            });
        }, 'json');
    }();
</script>
@endsection
<!-- end:: js local -->