@extends('layouts.main')

@section('title', 'BarangMasuk')

@section('css_page')
<!-- BEGIN VENDOR CSS-->
<!-- END VENDOR CSS-->

<!-- BEGIN Page Level CSS-->
<style>
    /* width */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #c8c8c8;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

</style>
<!-- END Page Level CSS-->
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <span class="text-muted font-weight-bold mr-4">
                    <i class="fa fa-layer-group text-success"></i>
                </span>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Barang Masuk</h5>
                <!--end::Actions-->
            </div>
            <div>
                <span class="mr-2 d-none d-lg-inline text-dark my-auto" id="time"></span>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->

            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Notice-->
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Data Barang Masuk
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->

                        @can('barangmasuk-C')
                        <div class="dropdown"></div>
                        <button class="btn btn-primary font-weight-bolder  dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" id="improt">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <!--end::Svg Icon-->
                            </span>Barang Masuk</a>
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" aria-labelledby="improt">
                            <!--begin::Navigation-->
                            <ul class="navi flex-column navi-hover py-2">
                                <li
                                    class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                    Pilih cara input:
                                </li>
                                <li class="navi-item">
                                    <a id="addMenu" name="addMenu" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-excel-o"></i>
                                        </span>
                                        <span class="navi-text">Form</span>
                                    </a>
                                </li>
                                </li>
                                <li class="navi-item">
                                    <a id="modalimportbarangmasuk" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-pdf-o"></i>
                                        </span>
                                        <span class="navi-text">Import</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                        @endcan
                        <!--end::Button-->
                        <!--begin::Button-->
                        <div class="dropdown">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="exprot">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                    <!--end::Svg Icon-->
                                </span>Export
                            </button>

                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" aria-labelledby="exprot">
                                <!--begin::Navigation-->
                                <ul class="navi flex-column navi-hover py-2">
                                    <li
                                        class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                        Choose an option:
                                    </li>
                                    <li class="navi-item">
                                        {{-- <a onclick="modalBulananExport()" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">bulanan</span>
                                        </a> --}}
                                    </li>
                                    </li>
                                    <li class="navi-item">
                                        <a onclick="modalTahunanExport()" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-pdf-o"></i>
                                            </span>
                                            <span class="navi-text">Tahunan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!--end::Navigation-->
                        </div>
                        <!--end::Button-->
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-7">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="Search..."
                                                id="kt_datatable_search_query" />
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Search Form-->
                    <!--end: Search Form-->
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_menu"></div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<!--begin:Modal-->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMenuTitle">Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <!--begin:Form-->
            <script src="script.js"></script>
            <form role="form" class="form" name="formmenus" id="formmenus" enctype="multipart/formdata" method="">
                <input type="hidden" name="barang_masuk_id" id="barang_masuk_id">
                <div class="modal-body" style="height: 500px;">
                    <div class="mb-7">
                        <!--  -->
                        <div class="form-group row" id="input_jenis">
                            <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                            <div class="col-lg-9">
                                <select class="form-control select2" id="jenis_code" name="jenis_code"
                                    style="width: 100%">
                                    <option value="" disabled selected>Pilih jenis barang</option>
                                    <option value="1">Consumable</option>
                                    <option value="2">Asset</option>
                                </select>
                                <span class="form-text text-muted">Pilih jenis barang untuk menampilkan opsi
                                    barang</span>
                            </div>
                        </div>
                        <div class="form-group row" id="input_kategori">
                            <label class="col-lg-3 col-form-label">Nama Kategori</label>
                            <div class="col-lg-9">
                                <select class="form-control select2" id="kategori_id" name="kategori_id"
                                    style="width: 100%">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($kategori as $k)
                                    <option value="{{$k->id}}">{{$k->nama_kategori}}</option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted">Masukkan Nama Kategori</span>
                            </div>
                        </div>
                        <div class="form-group row" id="input_barang">
                            <label class="col-lg-3 col-form-label">Barang</label>
                            <div class="col-lg-9">
                                <select class="form-control select2" id="barang_code" name="barang_code"
                                    style="width: 100%;">
                                    <option class="form-control" value="">Pilih barang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Jumlah Barang:</label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" min="1" id="jumlah" name="jumlah"
                                    placeholder="Contoh : 100" />
                                <span class="form-text text-muted">Masukkan Jumlah Barang</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                            class="fa fa-times"></i>membatalkan
                    </button>
                    @can(['barangmasuk-C' , 'barangmasuk-U'])
                    <button type="submit" id="saveMenu" data-id="" class="btn btn-primary font-weight-bold">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    @endcan
                </div>
            </form>
            <!--end:Form-->
        </div>
    </div>
</div>
<!--end:Modal-->
<!--begin:ModalInformasi-->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalnfoTitle">Informasi Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <!--begin:Form-->
            <script src="script.js"></script>
            <div class="modal-body" style="height: 500px;">
                <div class="mb-7">
                    <!--  -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Tanggal barang masuk:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="tanggal_barang_masuk"
                                name="tanggal_barang_masuk" readonly />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="jenis_code_detail" name="jenis_code" readonly />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Kategori Barang:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="kategori_barang_info" name="nama_kategori"
                                readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Barang:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="barang_code_detail" name="barang_code"
                                readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Jumlah Barang masuk:</label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" id="jumlah_barang_masuk"
                                name="jumlah_barang_masuk " readonly />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Jumlah stok Barang:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="stok_detail" name="stok_detail" readonly />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">keterangan:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" readonly />

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                        class="fa fa-times"></i>Tutup
            </div>

            <!--end:Form-->
        </div>
    </div>
</div>
<!--end:Modal-->

<!--Modal Import-->
<div class="modal fade" id="modalimportbarangmasukadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMenuimportTitle">Import data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <!--begin:Form-->
            <form role="form" class="form" name="formmenusimport" id="formimportsmasuk" enctype="multipart/formdata"
                method="">
                <div class="modal-body" style="height: 400px;">
                    <div class="mb-7">
                        <div class="row">
                            <label class="col-lg-3 col-form-label">File import isian:</label>
                            <div class="col-lg-9 text-center">
                                <button type="button" class="btn btn-primary" id="importdummymasuk"
                                    style="width: 100%">Download File isi import</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">File import:</label>
                            <div class="col-lg-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileimportuploadmasuk" required>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <span class="form-text text-muted"> Download file untuk entri data </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                            class="fa fa-times"></i>membatalkan
                    </button>
                    @can(['barangmasuk-C' , 'barangmasuk-U'])
                    <button type="submit" id="saveMenuimportmasuk" data-id="" class="btn btn-primary font-weight-bold">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    @endcan
                </div>
            </form>
            <!--end:Form-->
        </div>
    </div>
</div>
            <!--begin:Modal bulanan-->
            <div class="modal fade" id="exportBulanan" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMenuTitle">Barang Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="mb-7">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">tanggal awal:</label>
                                        <div class="col-lg-9">
                                            <input type='date' class="form-control" id="tgl_awal"
                                                placeholder="Select time" />
                                            <span class="form-text text-muted">Masukkan tanggal</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="mb-7">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">tanggal akhir:</label>
                                        <div class="col-lg-9">
                                            <input type='date' class="form-control" id="tgl_akhir"
                                                placeholder="Select time" />
                                            <span class="form-text text-muted">Masukkan tanggal</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-export_excel">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:Modal-->
            <!--begin:Modal Tahunan-->
            <div class="modal fade" id="exportTahunan" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMenuTitle">Barang Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="mb-7">
                                    <div class="form-group row">
                                        <h5> apakah anda ingin membuat tahun ini?</h5>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right btn-export_pdf">Save
                                changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:Modal-->

            @endsection

            @section('js_page')
            <!--begin::Page Vendors(used by this page)-->
            <!--end::Page Vendors-->
            <!--begin::Page Scripts(used by this page)-->
            <!--end::Page Scripts-->

            <script type="text/javascript">
                $(document).ready(function () {
                    $('.btn-export_excel').on('click', function () {
                        var tanggal_awal = new Date($('#tgl_awal').val());
                        var tanggal_akhir = new Date($('#tgl_akhir').val());
                        if (tanggal_akhir < tanggal_awal) {
                            toastr.warning('Tanggal akhir tidak boleh lebih kecil dari tanggal awal');
                            return false;
                        }
                        $.ajax({
                            xhrFields: {
                                responseType: 'blob',
                            },
                            url: './barangmasuk-export',
                            type: "Post",
                            data: {
                                tanggal_awal: $('#tgl_awal').val(),
                                tanggal_akhir: $('#tgl_akhir').val(),
                            },
                            success: function (result, status, xhr) {
                                var disposition = xhr.getResponseHeader(
                                    'content-disposition');
                                var filename = ('Laporan Masuk Bulanan.xlsx');

                                var blob = new Blob([result], {
                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = filename;
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }

                        })
                    })

                    $('.btn-export_pdf').on('click', function () {
                        $.ajax({
                            xhrFields: {
                                responseType: 'blob',
                            },
                            url: './barangmasuk-export-tahunan',
                            type: "get",
                            success: function () {
                                window.location.href = './barangmasuk-export-tahunan';
                            }
                        })
                    })


                    $('.select2').select2();
                    $('#jenis_code').on('change', function () {
                        var jenis_code = $('#jenis_code').val();
                        if (jenis_code) {
                            $.ajax({
                                url: './getkategori/' + jenis_code,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $('select[name="kategori_id"]').empty();
                                    $('select[name="kategori_id"]').append(
                                        '<option value="" disabled selected>Pilih Kategori</option>'
                                        );
                                    $.each(data, function (key, value) {
                                        $('select[name="kategori_id"]').append(
                                            '<option value="' + value.id +
                                            '">' +
                                            value.nama_kategori + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('select[name="barang_code"]').empty();
                        }
                    });

                    $('#kategori_id').on('change', function () {
                        var kategori_id = $(this).val(); // Use $(this).val() to get the selected value

                        if (kategori_id) {
                            $.ajax({
                                url: './getBarang/' + kategori_id,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $('select[name="barang_code"]').empty();
                                    $('select[name="barang_code"]').append(
                                        '<option value="" disabled selected>Pilih Barang</option>'
                                        );
                                    $.each(data, function (key, value) {
                                        $('select[name="barang_code"]').append(
                                            '<option value="' + value
                                            .barang_id + '">' +
                                            value.nama_barang + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('select[name="barang_code"]').empty();
                        }
                    });


                    var datatable = $('#kt_datatable_menu');

                    @can('barangmasuk-R')

                    datatable.KTDatatable({
                        // datasource definition
                        data: {
                            type: 'remote',
                            source: {
                                read: {
                                    method: 'GET',
                                    url: '/BarangMasuk/list'
                                }
                            },
                            pageSize: 10,
                        },
                        // layout definition
                        layout: {
                            scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                            footer: false // display/hide footer
                        },
                        // column sorting
                        sortable: true,
                        pagination: true,
                        search: {
                            input: $('#kt_datatable_search_query'),
                            key: 'generalSearch'
                        },
                        // columns definition
                        columns: [{
                                field: 'DT_RowIndex',
                                title: 'No',

                            },
                            {
                                field: 'tanggal_barang_masuk',
                                title: 'tanggal barang masuk',
                                textAlign: 'center',
                            },
                            {
                                field: 'jenis_barang',
                                title: 'jenis barang',
                                textAlign: 'center',
                            },

                            {
                                field: 'nama_barang',
                                title: 'barang',
                                textAlign: 'center',
                            },
                            {
                                field: 'jumlah_barang_masuk',
                                title: 'jumlah barang masuk',
                                textAlign: 'center',
                            },
                            {
                                field: 'jumlah_barang',
                                title: 'stok barang',
                                textAlign: 'center',

                            },

                            {
                                field: 'Actions',
                                title: 'Actions',
                                sortable: false,
                                width: 125,
                                autoHide: false,
                                overflow: 'visible',
                                template: function (row) {
                                    return "<center>" +
                                        @can('barangmasuk-U')
                                    "<button type='button' class='edits btn btn-sm btn-icon btn-outline-warning ' title='Edit' data-toggle='tooltip' data-id=" +
                                    row.id_barang_masuk +
                                        " ><i class='fa fa-edit'></i> </button>  " +
                                        @endcan
                                    @can('barangmasuk-D')
                                    "<button type='button' class='deletes btn-sm btn btn-icon btn-outline-danger' title='Delete' data-toggle='tooltip' alt='' data-id=" +
                                    row.id_barang_masuk +
                                        " ><i class='fa fa-trash'></i></button>  " +
                                        @endcan
                                    @can('barangmasuk-R')
                                    "<button type='button' class='details btn-sm btn btn-icon btn-outline-info' title='Detail' data-toggle='tooltip' alt='' data-id=" +
                                    row.id_barang_masuk + " data-tanggal_barang_masuk=" + row
                                        .tanggal_barang_masuk + " data-nama_barang=" + row
                                        .nama_barang +
                                        " data-jenis_barang=" + row.jenis_barang +
                                        " data-jumlah_barang_masuk=" + row.jumlah_barang_masuk +
                                        " data-jumlah_barang=" + row.jumlah_barang +
                                        " data-keterangan_barang=" + row.keterangan_barang +
                                        " data-nama_kategori=" + row.nama_kategori +

                                        " ><i class='fa fa-eye'></i></button>  " +
                                        @endcan

                                    "</center>";
                                },
                            }
                        ],



                    });
                    @endcan

                    @can('barangmasuk-C')
                    $(document).on('click', '#addMenu', function () {
                        $("#saveMenu").data("id", "");
                        $('#modalMenuTitle').text('Tambah Barang Masuk');
                        $('#modalMenu').modal('show');
                        $(`.form-control`).removeClass('is-invalid');
                        $(`.invalid-feedback`).remove();
                        let form = document.forms.formmenus; // <form name="formmenus"> element
                        form.reset();
                        $('#barang_code').val('').trigger('change');
                        $('#input_barang').removeClass('d-none');
                        $('#jenis_code').attr('disabled', false);
                        $('#input_jenis').val('').removeClass('d-none');
                        $('#kategori_id').attr('disabled', false);
                        $('#input_kategori').val('').removeClass('d-none');
                        $('#barang_code').attr('disabled', false);
                    });

                    @endcan

                    $(document).on('click', '#saveMenuimportmasuk', function (e) {
                        e.preventDefault();
                        var fileimportupload = $('#fileimportuploadmasuk').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('fileimportuploadmasuk', fileimportupload);
                        $.ajax({
                            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                            url: './barangmasuk/import', // the url where we want to POST
                            data: form_data,
                            dataType: 'JSON', // what type of data do we expect back from the server
                            contentType: false,
                            processData: false,
                        }).done(function (res) {
                            // reset form
                            $('#modalimportbarangmasukadd').modal('hide');
                            showtoastr('success', res.message);
                            $("#saveMenuimportmasuk").data("id", "");
                            $("#formimportsmasuk")[0].reset();
                            menuID = "";
                            let form = document.forms
                            .formimportsmasuk; // <form name="formmenus"> element
                            form.reset();
                            datatable.reload();
                        })

                    })


                    @can('barangmasuk-U')
                    $(document).on('click', '.edits', function () {
                        $.ajax({
                            type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                            url: './barangmasuk/' + $(this).data(
                            'id'), // the url where we want to POST
                            beforeSend: function () {
                                let form = document.forms
                                .formmenus; // <form name="formmenus"> element
                                form.reset();
                                $(`.form-control`).removeClass('is-invalid');
                                $(`.invalid-feedback`).remove();
                            }
                        }).done(function (res) {
                            $('#jenis_code').attr('disabled', true);
                            $('#kategori_id').attr('disabled', true);
                            $('#barang_code').attr('disabled', true);
                            let form = document.forms
                            .formmenus; // <form name="formmenus"> element
                            console.log(res.success);
                            if (res.success) {
                                showtoastr('success', res.message);
                                $('#barang_masuk_id').val(res.data[0].barang_masuk_id);
                                $('#jenis_code').val(res.data[0].jenis_barang).trigger(
                                'change');
                                $('#input_jenis').addClass('d-none');
                                $('#barang_code').val(res.data[0].barang_id).trigger('change');
                                $('#input_barang').addClass('d-none');
                                $('#jumlah').val(res.data[0].jumlah_barang_masuk);
                                $('#kategori_id').val(res.data[0].kategori_id).trigger(
                                'change');
                                $('#input_kategori').addClass('d-none');
                                $("#saveMenu").data("id", res.data[0].barang_masuk_id);
                                setkategori(res.data[0].jenis_barang, res.data[0].kategori_id);
                                setBarang(res.data[0].barang_id, res.data[0].kategori_id);
                            }
                        }).fail(function (data) {
                            show_toastr('error', data.responseJSON.status, data.responseJSON
                                .message);
                            $.each(data.responseJSON.errors, function (index, value) {
                                show_toastr('error', index, value);
                            });
                        }).always(function () {
                            $('#modalMenuTitle').text('Edit Data Barang');
                            $('#modalMenu').modal('show');
                        });
                    });

                    @endcan

                    function setkategori(param1, param2) {
                        $.ajax({
                            url: './getkategori/' + param1,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('#kategori_id').empty();
                                $('#kategori_id').append(
                                '<option value="">Pilih Kategori</option>');
                                $.each(data, function (key, value) {
                                    if (value.kategori_id == param2) {
                                        $('#kategori_id').append('<option value="' + value
                                            .kategori_id + '" selected>' + value
                                            .nama_kategori + '</option>');
                                    } else {
                                        $('#kategori_id').append('<option value="' + value
                                            .kategori_id + '">' + value.nama_kategori +
                                            '</option>');
                                    }
                                });
                            }
                        });
                    }

                    function setBarang(param1, param2) {
                        $.ajax({
                            url: './getBarang/' + param2,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('#barang_code').empty();
                                $('#barang_code').append('<option value="">Pilih Barang</option>');
                                $.each(data, function (key, value) {
                                    if (value.barang_id == param1) {
                                        $('#barang_code').append('<option value="' + value
                                            .barang_id + '" selected>' + value
                                            .nama_barang + '</option>');
                                    } else {
                                        $('#barang_code').append('<option value="' + value
                                            .barang_id + '">' + value.nama_barang +
                                            '</option>');
                                    }
                                });
                            }
                        });
                    }

                    $(document).on('click', '.details', function () {
                        $('#tanggal_barang_masuk').val($(this).data('tanggal_barang_masuk'));
                        var jenis_barang = $(this).data('jenis_barang');
                        if (jenis_barang == 1) {
                            $('#jenis_code_detail').val('Persediaan');
                        } else {
                            $('#jenis_code_detail').val('Asset');
                        }
                        $('#barang_code_detail').val($(this).data('nama_barang'));
                        $('#jumlah_barang_masuk').val($(this).data('jumlah_barang_masuk'));
                        $('#kategori_barang_info').val($(this).data('nama_kategori'));


                        // alert($(this).data('jumlah_barang'));
                        $('#stok_detail').val($(this).data('jumlah_barang'));
                        $('#keterangan').val($(this).data('keterangan_barang'));
                        //modal untuk show
                        $('#modalInfo').modal('show');
                    });




                    @can(['barangmasuk-C', 'barangmasuk-U'])
                    $('#formmenus').submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData($("#formmenus")[0]);
                        // var formData = $('#formmenus').serializeArray(); // our data object
                        var method = "POST";
                        let menuID = $("#saveMenu").data("id");

                        if (typeof menuID == "undefined" || menuID == "") {
                            var url = `./barangmasuk`;
                            if ($('#jenis_code').val() == "") {
                                toastr.warning('Jenis Barang tidak boleh kosong');
                                return false;
                            }
                            if ($('#kategori_id').val() == "") {
                                toastr.warning('Kategori Barang tidak boleh kosong');
                                return false;
                            }
                            if ($('#barang_code').val() == "") {
                                toastr.warning('Barang tidak boleh kosong');
                                return false;
                            }
                        } else {
                            var url = `./barangmasuk/${menuID}/update`;
                        }
                        //var url = (menuID != "" || menuID != undefined) ? `./company/${menuID}/update` : `./company`;

                        $.ajax({
                            type: method, // define the type of HTTP verb we want to use (POST for our form)
                            url: url, // the url where we want to POST
                            data: formData,
                            dataType: 'JSON', // what type of data do we expect back from the server
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $(`.form-control`).removeClass('is-invalid');
                                $(`.invalid-feedback`).remove();
                                $('#saveMenu').attr('disabled', true).html(
                                    "<i class='fa fa-spinner fa-spin'></i> processing");
                            }
                        }).done(function (data) {
                            $("#modalMenu").modal('hide');
                            showtoastr('success', data.message);
                            $("#saveMenu").data("id", "");
                            $("#formmenus")[0].reset();
                            menuID = "";
                            let form = document.forms
                            .formmenus; // <form name="formmenus"> element
                            form.reset();
                            datatable.reload();
                        }).fail(function (data) {
                            show_toastr('error', data.responseJSON.status, data.responseJSON
                                .message);
                            $.each(data.responseJSON.errors, function (index, value) {
                                if ($(`input[name='${index}']`)) {
                                    $(`input[name='${index}']`).addClass(`is-invalid`);
                                    $(`input[name='${index}']`).after(
                                        `<div class="invalid-feedback">${value}</div>`
                                        );
                                }
                                show_toastr('error', index, value);
                            });
                        }).always(function () {
                            $('#saveMenu').attr('disabled', false).html(
                                "<i class='fa fa-save'></i> Save");
                        });
                    });
                    @endcan



                    @can('barangmasuk-D')
                    $(document).on('click', '.deletes', function () {
                        Swal.fire({
                                title: 'Apakah anda ingin menghapus data ini?',
                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ya, hapus data!'
                            })
                            .then(isConfirm => {
                                if (isConfirm.isConfirmed) {
                                    $.ajax({
                                            type: 'DELETE', // define the type of HTTP verb we want to use (POST for our form)
                                            url: './barangmasuk/' + $(this).data(
                                                'id'), // the url where we want to POST
                                        })
                                        .done(function (data) {
                                            showtoastr('success', data.message);
                                        })
                                        .fail(function (data) {
                                            show_toastr('error', data.responseJSON.status, data
                                                .responseJSON
                                                .message);
                                            $.each(data.responseJSON.messages, function (index,
                                                value) {
                                                show_toastr('error', index, value);
                                            });
                                        })
                                        .always(function () {
                                            datatable.reload();
                                        });
                                } else {
                                    show_toastr('error', 'internal Server Error');
                                }
                            });
                    });
                    @endcan

                    $(document).on('click', '#importdummymasuk', function () {
                        // download file
                        $.ajax({
                            xhrFields: {
                                responseType: 'blob',
                            },
                            type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                            url: './templatebarangmasuk', // the url where we want to POST
                            success: function (result, status, xhr) {
                                var disposition = xhr.getResponseHeader(
                                    'content-disposition');
                                var filename = ('template barang masuk.xlsx');

                                var blob = new Blob([result], {
                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = filename;
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        })
                    })
                    $(document).on('click', '#modalimportbarangmasuk', function () {
                        $('#modalimportbarangmasukadd').modal('show');
                    });


                });



                function modalBulananExport() {
                    $('#exportBulanan').modal('show')
                }

                function modalTahunanExport() {
                    $('#exportTahunan').modal('show')
                }

                document.getElementById('jenis_code').addEventListener('change', function () {
                    var jenisCode = this.value;
                    if (jenisCode) {
                        // Mengirim permintaan AJAX untuk mendapatkan daftar barang berdasarkan jenis barang yang dipilih
                        fetch('/get-barang-by-code/' + jenisCode)
                            .then(function (response) {
                                return response.json();
                            })
                            .then(function (data) {
                                // Menghapus semua opsi sebelumnya dari daftar barang
                                var daftarBarangSelect = document.getElementById('daftarBarang');
                                daftarBarangSelect.innerHTML = '<option value="">Pilih Barang</option>';
                                // Menambahkan opsi baru ke daftar barang berdasarkan data yang diterima dari permintaan AJAX
                                data.forEach(function (barang) {
                                    var option = document.createElement('option');
                                    option.value = barang.barang_id;
                                    option.textContent = barang.nama_barang;
                                    daftarBarangSelect.appendChild(option);
                                });
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    } else {
                        // Jika jenis barang tidak dipilih, menghapus semua opsi dari daftar barang
                        var daftarBarangSelect = document.getElementById('daftarBarang');
                        daftarBarangSelect.innerHTML = '<option value="">Pilih Barang</option>';
                    }
                });

            </script>

            @endsection
