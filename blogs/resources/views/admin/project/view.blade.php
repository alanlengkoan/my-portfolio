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
                        {{ Breadcrumbs::render('admin.project') }}
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
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.project.add') }}" id="add" class="btn btn-light btn-sm">
                                <i class="fa fa-plus"></i>&nbsp;Create
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="tabel-project-dt">
                        </table>
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

<script>
    let untukTabel = function() {
        table = $('#tabel-project-dt').DataTable({
            serverSide: true,
            responsive: true,
            processing: true,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                emptyTable: "Tak ada data yang tersedia pada tabel ini.",
                processing: "Data sedang diproses...",
            },
            ajax: "{{ route('admin.project.get_data_dt') }}",
            columns: [{
                    title: 'No.',
                    data: 'DT_RowIndex',
                    class: 'text-center'
                },
                {
                    title: 'Judul',
                    data: 'judul',
                    class: 'text-center'
                },
                {
                    title: 'Link Demo',
                    data: 'link_demo',
                    class: 'text-center'
                },
                {
                    title: 'Link Github',
                    data: 'link_github',
                    class: 'text-center'
                },
                {
                    title: 'Gambar',
                    data: null,
                    class: 'text-center',
                    render: function(data, type, full, meta) {
                        var checkGambar = (full.gambar === null ? '//placehold.co/150' : `{{ asset_upload('picture/` + full.gambar + `') }}`);
                        return `<img src="` + checkGambar + `" width="170" height="100" >`;
                    },
                },
                {
                    title: 'Aksi',
                    data: null,
                    className: 'text-center',
                    responsivePriority: -1,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var urlDetail = "{{ route('admin.project.det', ':id') }}".replace(':id', full.id_project);
                        var urlUpdate = "{{ route('admin.project.upd', ':id') }}".replace(':id', full.id_project);

                        return `
                            <a href="` + urlDetail + `" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i>&nbsp;Detail</a>&nbsp;
                            <a href="` + urlUpdate + `" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i>&nbsp;Ubah</a>&nbsp;
                            <button type="button" id="del" data-id="` + full.id_project + `" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                        `;
                    },
                },
            ],
        });
    }();

    let untukHapusData = function() {
        $(document).on('click', '#del', function() {
            var ini = $(this);
            Swal.fire({
                title: "Apakah Anda yakin ingin menghapusnya?",
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((del) => {
                if (del.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('admin.project.del') }}",
                        dataType: 'json',
                        data: {
                            id: ini.data('id'),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            ini.attr('disabled', 'disabled');
                            ini.html('<i class="fa fa-spinner"></i>&nbsp;Menunggu...');
                        },
                        success: function(response) {
                            swal(response.title, response.text, response.type, response.button).then((value) => {
                                table.ajax.reload();
                            });
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    }();
</script>
@endsection
<!-- end:: js local -->