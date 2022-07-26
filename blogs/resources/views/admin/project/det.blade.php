<!-- begin:: base -->
@extends('admin/base')
<!-- end:: base -->

<!-- begin:: css local -->
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.15.1/devicon.min.css">
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
                        {{ Breadcrumbs::render('admin.project.det', $project) }}
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
                            <form>
                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="judul" class="form-control-plaintext" value="{{ $project->judul }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="deskripsi" class="form-control-plaintext" value="{{ $project->deskripsi }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="link_demo" class="col-sm-2 col-form-label">Link Demo</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="link_demo" class="form-control-plaintext" value="{{ $project->link_demo }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Link Github</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="link_github" class="form-control-plaintext" value="{{ $project->link_github }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="id_stack" class="col-sm-2 col-form-label">Stack</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            @foreach($project_stack as $row)
                                            <div class="col-lg-2 align-items-center text-center">
                                                <i class="devicon-{{ $row->toStack->icon }}-plain colored" style="font-size: 25px;"></i>
                                                <br>
                                                {{ $row->toStack->nama }}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <img src="{{ asset_upload('picture/'.$project->gambar) }}" alt="{{ $project->judul }}" class="img-fluid" width="500" />
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="link_github" class="col-sm-2 col-form-label">Detail Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            @foreach($project_picture as $row)
                                            <div class="col-lg-3 pt-3 pb-3">
                                                <img src="{{ asset_upload('picture/'.$row->picture) }}" alt="{{ $row->judul }}" class="img-fluid" />
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <a href="{{ route('admin.project') }}" id="back" class="btn btn-primary btn-sm">
                                            <i class="fa fa-arrow-left"></i>&nbsp;Back
                                        </a>
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
@endsection
<!-- end:: js local -->