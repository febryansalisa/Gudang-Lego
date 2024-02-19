@extends('layouts.main')

@section('title', 'BarangKeluar')

@section('css_page')
<!-- BEGIN VENDOR CSS-->
<!-- END VENDOR CSS-->
{{--  --}}
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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Barang Keluar</h5>
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
                        <h3 class="card-label">Data Barang Keluar
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        @can('barangkeluar-C')
                        <button id="addMenu" name="addMenu" class="btn btn-primary mx-1 font-weight-bolder">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <!--end::Svg Icon-->
                            </span>keluarkan barang</a>
                        </button>
                        @endcan
                        <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                <!--end::Svg Icon-->
                            </span>Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi flex-column navi-hover py-2">
                                <li
                                    class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                    Choose an option:
                                </li>
                                <li class="navi-item" id="export_bulanan">
                                    <a onclick="modalBulananExport()" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-excel-o"></i>
                                        </span>
                                        <span class="navi-text">bulanan</span>
                                    </a>
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
                            <!--end::Navigation-->
                            <!--end::Button-->
                        </div>
                    </div>
                </div>

                <div class="card-body">
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
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_menu"></div>
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
                    <h5 class="modal-title" id="modalMenuTitle">barang </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin:Form-->
                <!-- <script src="script.js"></script> -->
                <form role="form" class="form" name="formmenus" id="formmenus" enctype="multipart/formdata" method="">
                    <div class="modal-body" style="height: 500px;">
                        <div class="mb-7">
                            <input type="hidden" name="user_code" id="user_code">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nomor Pesanan:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="nodofetiket_code"
                                        name="nodofetiket_code" placeholder="Contoh : SHP-23-01223/TKP-10571" />
                                    <span class="form-text text-muted">masukan nomor pesanan</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">PIC:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="pic_code" name="pic_code"
                                        placeholder="Contoh :mr andy dermawan BGT/Department Keamanan"  />
                                    <span class="form-text text-muted">masukan Nama PIC (</span>
                                </div>
                            </div>
                            <!--  -->
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="jenis_code" name="jenis_code" style="width: 100%">
                                        <option value="">Pilih jenis barang</option>
                                        <option value="1">Consumable</option>
                                        <option value="2">Asset</option>
                                    </select>
                                    <span class="form-text text-muted">Pilih jenis barang untuk menampilkan opsi barang</span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama Kategori</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="kategori_id" name="kategori_id" style="width: 100%">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategori as $k)
                                            <option value="{{$k->id}}">{{$k->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-muted">Masukkan Nama Kategori</span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Barang:</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="barang_code" name="barang_code" style="width: 100%;">
                                        <option class="form-control" value="" disabled selected>Pilih barang</option>
                                    </select>
                                </div>
                            </div>

                       
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jumlah Barang:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" min="1" id="jumlah" name="jumlah"
                                        placeholder="Contoh : 100" />
                                        <span class="form-text text-muted" >barang yang tersedia saat ini
                                        <span id="jumlah_stok"> </span>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" id="keterangan_label">Keterangan Barang:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="keterangan_code" name="keterangan_code"
                                        placeholder="Contoh : untuk router" />
                                    <span class="form-text text-muted">Masukkan keterangan Barang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                                class="fa fa-times"></i>Membatalkan
                        </button>
                        @can(['barangkeluar-C' , ])
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


    <!--end:Modal -->

    {{-- modal edit --}}
    <div class="modal fade" id="modalMenuEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMenuTitleedit"> edit barang keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin:Form-->
                <!-- <script src="script.js"></script> -->
                <form role="form" class="form" name="formmenus" id="formmenusedit" enctype="multipart/formdata"
                    method="">
                    <div class="modal-body" style="height: 500px;">
                        <div class="mb-7">
                            <input type="hidden" name="user_code_edit" id="user_code_edit">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nomor Pesanan:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="nodofetiket_code_edit"
                                        name="nodofetiket_code" placeholder="Contoh : SHP-23-01223/TKP-10571" />
                                    <span class="form-text text-muted">masukan Nomor Pesanan</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">PIC:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="pic_code_edit" name="pic_code_edit"
                                        placeholder="Contoh :mr andy dermawan BGT/Department Keamanan"  />
                                    <span class="form-text text-muted">masukan Nama PIC (</span>
                                </div>
                            </div>
                            <!--  -->
                            {{-- <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="jenis_code_edit" name="jenis_code" style="width: 100%>
                                    <option value="">Pilih jenis barang</option>
                                    <option value=" 1">Consumable</option>
                                        <option value="2">Asset</option>
                                    </select>
                                    <span class="form-text text-muted">Pilih jenis barang untuk menampilkan opsi
                                        barang</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama Kategori</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="kategori_id_edit" name="kategori_id" style="width: 100%>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $k)
                                        <option value=" {{$k->id}}">{{$k->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-muted">Masukkan Nama Kategori</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Barang:</label>
                                <div class="col-lg-9">
                                    <select class="form-control select2" id="barang_code_id_edit" name="barang_code"
                                        style="width: 100%;">
                                        <option class="form-control" value=''>Pilih barang</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jumlah Barang:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" min="1" id="jumlah_edit" name="jumlah_edit"
                                        placeholder="Contoh : 100" />
                                    <span class="form-text text-muted">Masukkan Jumlah Barang</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" id="keterangan_label_edit">Keterangan Barang:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="keterangan_code_edit"
                                        name="keterangan_code_edit" placeholder="Contoh : untuk router" />
                                    <span class="form-text text-muted">Masukkan keterangan Barang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                                class="fa fa-times"></i>Membatalkan
                        </button>
                        @can(['barangkeluar-U'])
                        <button type="submit" id="saveMenuedit" data-id="" class="btn btn-primary font-weight-bold">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        @endcan
                    </div>
                </form>
                <!--end:Form-->
            </div>
        </div>
    </div>


    {{-- modal Return --}}
    <div class="modal fade" id="modalReturn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReturnTitle">Return barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <!--begin:Form-->
                <script src="script.js"></script>
                <form role="form" class="form" name="formreturn" id="formreturn" enctype="multipart/formdata" method="">
                    <input type="hidden" name="id_barang_keluar" id="id_barang_keluar">

                    <div class="modal-body" style="height: 500px;">
                        <div class="mb-7">
                            <input type="hidden" name="user_code" id="user_code">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nomor Pesanan:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="nodof_code" name="nodofetiket_code"
                                        placeholder="Contoh : 10451 /GS-10571" disabled />
                                    <span class="form-text text-muted">Nomor Pesanan(</span>
                                </div>
                            </div>                          
                            <!--  -->
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="tipebarang_code" name="jenis_code"
                                        disabled>
                                    <span class="form-text text-muted">Pilih jenis barang untuk menampilkan opsi
                                        barang</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama Kategori:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="kategori_return" name="kategori_return"
                                        disabled>
                                    <span class="form-text text-muted">Masukkan Nama Kategori</span>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="barang_id" name="barang_id">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Barang:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="barangdikembalikan_code"
                                        name="barang_code" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Jumlah Barang:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" id="jumlahdikembalikan" name="jumlah"
                                        placeholder="Contoh : 100" />
                                    <span class="form-text text-muted">Masukkan Jumlah Barang</span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i
                                class="fa fa-times"></i>Membatalkan
                        </button>
                        @can(['barangkeluar-C' , 'barangkeluar-U'])
                        <button type="submit" id="btn_return_barang" data-id=""
                            class="btn btn-primary font-weight-bold">
                            <i class="fa fa-reply"></i> Simpan
                        </button>
                        @endcan
                    </div>
                </form>
                <!--end:Form-->
            </div>
        </div>
    </div>


    <!--begin:Modal info-->
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoTitle">Informasi Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin:Form-->
                <!-- <script src="script.js"></script> -->
                <!-- <form role="form" class="form" name="formmenus" id="formmenus" enctype="multipart/formdata" method=""> -->
                <div class="modal-body" style="height: 500px;">
                    <div class="mb-7">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama Pengambil Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="user_code_detail" id="user_code_detail"
                                    readonly>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Tgl Pengambilan:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="tgl_pengambilan" name="tgl_pengambilan"
                                    readonly />
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nomor Pesanan:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="nodofetiket_code_detail"
                                    name="nodofetiket_code_detail" readonly />
                                <span class="form-text text-muted">Nomor Pesanan</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">PIC:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="pic_code_detail" name="pic_code_detail"
                                    readonly />
                     
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="jenis_code_detail" name="jenis_code_detail"
                                    readonly />
                                <span class="form-text text-muted">Masukkan Jenis Barang</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Kategori Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="kategori_barang" name="kategori_barang"
                                    placeholder="Contoh : Totolink N200RE Mini" readonly />
                                <span class="form-text text-muted">Masukkan kategori Barang</span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="nama_code_detail" name="nama_code_detail"
                                    readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Kode Barcode:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="barcode_detail" name="barcode_detail"
                                    placeholder="contoh:SW.PG.abc.123.123" readonly />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Keterangan Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="keterangan_code_detail"
                                    name="keterangan_code_detail" readonly />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Jumlah Barang Keluar:</label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" id="jumlah_detail" name="jumlah_detail"
                                    readonly />

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                            <i class="fa fa-times"></i>Membatalkan
                        </button>
                    </div>
                </div>

            </div>
            <!--end:Form-->
        </div>
    </div>



    <!--end:Modal-->

    <!--begin:Modal bulanan-->
    <div class="modal fade" id="BulananExportkeluar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMenuTitle">Laporan Bulanan Barang Keluar</h5>
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
                                    <input type='date' class="form-control" id="tgl_awal" placeholder="Select time" />
                                    <span class="form-text text-muted">Masukkan tanggal</span>
                                </div>

                            </div>
                        </div>

                        <div class="mb-7">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">tanggal akhir:</label>
                                <div class="col-lg-9">
                                    <input type='date' class="form-control" id="tgl_akhir" placeholder="Select time" />
                                    <span class="form-text text-muted">Masukkan tanggal</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-export_excel">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--end:Modal-->
    <!--begin:Modal Tahunan-->
    <div class="modal fade" id="exportTahunankeluar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMenuTitle">Laporan Tahunan Barang Masuk</h5>
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
                    <button type="submit" class="btn btn-primary btn-export_pdf">Save changes</button>
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

            //select data dari barang 
            $('.select2').select2();
            $('#jenis_code').on('change', function () {
                if ($(this).val() == '1') {
                    $('#keterangan_label').text('Keterangan Barang:');
                } else {
                    $('#keterangan_label').text('Keterangan Lokasi:');
                }
            })
            $('#jenis_code_edit').on('change', function () {
                var jenis_code = $('#jenis_code_edit').val();
                var kategori_id = $('#kategori_id').val();
                if (jenis_code) {
                    $.ajax({
                        url: './getkategori/' + jenis_code,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="kategori_id_edit"]').empty();
                            $('select[name="kategori_id_edit"]').append(
                                '<option value="">Pilih Kategori</option>');
                            $.each(data, function (key, value) {
                                $('select[name="kategori_id_edit"]').append(
                                    '<option value="' + value.id + '">' +
                                    value.nama_kategori + '</option>');
                            });
                        }
                    });
                } else {

                    $('select[name="barang_code"]').empty();
                }
            });

            $('#jenis_code').on('change', function () {
                var jenis_code = $('#jenis_code').val();
                var kategori_id = $('#kategori_id').val();                
                if (jenis_code) {
                    $.ajax({
                        url: './getkategori/' + jenis_code,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="kategori_id"]').empty();
                            $('select[name="kategori_id"]').append(
                                '<option value="">Pilih Kategori</option>');
                            $.each(data, function (key, value) {
                                $('select[name="kategori_id"]').append(
                                    '<option value="' + value.id + '">' +
                                    value.nama_kategori + '</option>');                          

                            });
                        }
                    });
                } else {

                    $('select[name="barang_code"]').empty();
                }
            });

            $('#kategori_id_edit').on('change', function () {
                var kategori_id = $('#kategori_id_edit').val();
                
                if (kategori_id) {
                    $.ajax({
                        url: './getBarang/' + kategori_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="barang_code_edit"]').empty();
                            $('select[name="barang_code_edit"]').append(
                                '<option value="">Pilih Barang</option>');
                            $.each(data, function (key, value) {
                                $('select[name="barang_code_edit"]').append(
                                    '<option value="' + value.barang_id + '">' +
                                    value.nama_barang + '</option>');
                            });
                        }
                    });
                } else {

                    $('select[name="barang_code"]').empty();
                }
            });

            $('#kategori_id').on('change', function () {
                var kategori_id = $('#kategori_id').val();
               
                if (kategori_id) {
                    $.ajax({
                        url: './getBarang/' + kategori_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="barang_code"]').empty();
                            $('select[name="barang_code"]').append(
                                '<option value="">Pilih Barang</option>');
                            $.each(data, function (key, value) {
                                $('select[name="barang_code"]').append(
                                    '<option value="' + value.barang_id + '">' +
                                    value.nama_barang + '</option>');               
                            });
                        }
                    });
                } else {

                    $('select[name="barang_code"]').empty();
                }
            });

            $('#barang_code').on('change', function () {
                var barang_id = $('#barang_code').val();
                if (barang_id) {
                    $.ajax({
                        url: './getStok/' + barang_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#jumlah_stok').empty();
                            $('#jumlah_stok').html(data[0].jumlah_barang);
                        }
                    });
                } else {

                    $('#jumlah_stok').empty();
                }
            });
            //datatable menampilkan data
            var datatable = $('#kt_datatable_menu');

            @can('barangkeluar-R')

            datatable.KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '/BarangKeluar/list'
                        }
                    },
                    pageSize: 10,
                },
                // layout definition
                layout: {
                    scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
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
                columns: [

                    {
                        field: 'DT_RowIndex',
                        title: 'No',
                        autoHide: false,
                    }, 
                   
                    {
                        field: 'nama_barang',
                        title: 'nama barang',
                        textAlign: 'center',
                        autoHide: false,

                    },
                    {
                        field: 'jumlah_barang_keluar',
                        title: 'jumlah',
                        textAlign: 'center',
                        autoHide: false,
                    },
                   
                    {
                        field: 'no_dof_etiket',
                        title: 'Nomor Pesanan',
                        textAlign: 'center',
                        autoHide: false,
                    },
                    {
                        field: 'tgl_pengambilan',
                        title: 'tanggal pengambilan',
                        textAlign: 'center',
                        autoHide: false,
                    },
                    {
                        field: 'keterangan',
                        title: 'keterangan',
                        overflow: 'visible',
                        autoHide: false,
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
                            var actions = "<center>";
                            // Edit button
                            @can('barangkeluar-U')
                            actions += "<button type='button' class='edits btn btn-sm btn-icon btn-outline-warning' title='Edit' data-toggle='tooltip' data-id=" + row.barang_keluar_id + " ><i class='fa fa-edit'></i> </button>  ";
                            @endcan

                            // Delete button
                            @can('barangkeluar-D')
                            actions += "<button type='button' class='deletes btn-sm btn btn-icon btn-outline-danger' title='Delete' data-toggle='tooltip' alt='' data-id=" + row.barang_keluar_id + " ><i class='fa fa-trash'></i></button>  ";
                            @endcan

                            // Return button (added condition)
                            if (row.jenis_barang == 1) {
                                @can('barangkeluar-U')
                                actions += "<button type='button' class='returns btn btn-sm btn-icon btn-outline-info' title='Return' data-toggle='tooltip' data-id=" + row.barang_keluar_id + " ><i class='fa fa-reply-all'></i> </button>  ";
                                @endcan
                            }

                            // Detail button
                            @can('barangkeluar-R')                          
                            actions += '<button type="button" class="details btn btn-sm btn-icon btn-outline-info" data-id="'  + row.barang_keluar_id + '" data-user_id="' + row.user_id + '" data-tgl_pengambilan="' + row.tgl_pengambilan + '" data-no_dof_etiket="' + row.no_dof_etiket + '" data-pic="' + row.pic + '" data-barcode="' + row.barcode_barang +'" data-jenis_barang="' + row.jenis_barang + '" data-keterangan="' + row.keterangan + '" data-jumlah_barang_keluar="' + row.jumlah_barang_keluar +  '"  data-nama_kategori="'  + row.nama_kategori + '"  data-nama="'  + row.nama_barang + '" ><i class="fa fa-info-circle"></i> </button>' 
                            @endcan

                            actions += "</center>";
                            return actions;
                        },
                    }
                ],


            });
            @endcan
            //menampilkan modal untuk menambahkan barang
            @can('barangkeluar-C')
            $(document).on('click', '#addMenu', function () {
                //mengkosongkan value id dalam membuat data baru
                $('#modalMenuTitle').text('Mengeluarkan Barang');
                $('#modalMenu').modal('show');
                $(`.form-control`).removeClass('is-invalid');
                $(`.invalid-feedback`).remove();
                let form = document.forms.formmenus; // <form name="formmenus"> element
                form.reset();
                $('#barang_code').val('').trigger('change'); // Select the option with a value of '1'
                //menonaktifkan select option dalam modal
                $('#jenis_code').attr('disabled', false);
                $('#kategori_id').attr('disabled', false);
                $('#barang_code').attr('disabled', false);
             
            });

            @endcan
            //menampilkan update modal menu dalam mengubah atau mengedit data
            @can('barangkeluar-U')
            $(document).on('click', '.edits', function () {
                $.ajax({
                    type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                    url: './barangkeluar/' + $(this).data(
                        'id'), // the url where we want to POST
                    beforeSend: function () {
                        let form = document.forms
                            .formmenusedit; // <form name="formmenus"> element
                        form.reset();
                        $(`.form-control`).removeClass('is-invalid');
                        $(`.invalid-feedback`).remove();
                    }
                }).done(function (res) {
                    //jika berhasil mengambil data untuk disable mengedit
                    $('#jenis_code_edit').attr('disabled', true);
                    $('#kategori_id_edit').attr('disabled', true);
                    $('#barang_code_id_edit').attr('disabled', true);
                    let form = document.forms.formmenusedit; // <form name="formmenus"> element
                    console.log(res.success);
                    if (res.success) {
                        //jika berhasil mengambil data untuk mengedit
                        showtoastr('success', res.message);
                        console.log(res.data);
                        if(res.data[0].jenis_barang == 1){
                            $('#keterangan_label_edit').text('Keterangan Barang:');
                        }else{
                            $('#keterangan_label_edit').text('Keterangan Lokasi:');
                        }
                        $('#nodofetiket_code_edit').val(res.data[0].no_dof_etiket);
                        $('#jumlah_edit').val(res.data[0].jumlah_barang_keluar);
                        $('#jenis_code_edit').val(res.data[0].jenis_barang).trigger('change');
                        $('#kategori_id_edit').val(res.data[0].kategori_id).trigger('change');
                        $('#barang_code_id_edit').val(res.data[0].barang_id).trigger('change');
                        $('#keterangan_code_edit').val(res.data[0].keterangan);
                        $('#pic_code_edit').val(res.data[0].pic);
                        
                        $("#saveMenuedit").attr("data-id", res.data[0].barang_keluar_id);
                        // alert(res.data[0].barang_id);
                        setkategoriedit(res.data[0].jenis_barang, res.data[0].kategori_id);
                        setBarangedit(res.data[0].barang_id, res.data[0].kategori_id);
                    }
                }).fail(function (data) {
                    //jika salah sebaliknya 
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        show_toastr('error', index, value);
                    });
                }).always(function () {
                    $('#modalMenuTitleedit').text('Edit Data Barang');
                    $('#modalMenuEdit').modal('show');
                });
            });
            //menampilkan modal menu return pada barang keluar
            $(document).on('click', '.returns', function () {
                $.ajax({
                    type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                    url: './returnbarang/' + $(this).data(
                        'id'), // the url where we want to POST
                    beforeSend: function () {
                        let form = document.forms
                            .formreturn; // <form name="formmenus"> element
                        form.reset();
                        $(`.form-control`).removeClass('is-invalid');
                        $(`.invalid-feedback`).remove();
                    },
                }).done(function (res) {
                    let form = document.forms.formmenus; // <form name="formmenus"> element
                    console.log(res.success);
                    if (res.success) {
                        showtoastr('success', res.message);
                        console.log(res.data[0])
                        $('#id_barang_keluar').val(res.data[0].barang_keluar_id);
                        // $('#tanggal_code').val(res.data.tanggal_keluar);
                        $('#barang_id').val(res.data[0].barang_id);
                        $('#nodof_code').val(res.data[0].no_dof_etiket);
                        $('#barangdikembalikan_code').val(res.data[0].nama_barang);
                        $('#tipebarang_code').val(res.data[0].jenis_barang);
                        $('#kategori_return').val(res.data[0].nama_kategori);
                        $("#saveMenu").data("id", res.data.barang_id);
                    }
                }).fail(function (data) {
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        show_toastr('error', index, value);
                    });
                }).always(function () {
                    $('#modalReturnTitle').text('Return Barang');
                    $('#modalReturn').modal('show');
                });
            });
            @endcan

            function setkategoriedit(param1, param2) {
                $.ajax({
                    url: './getkategori/' + param1,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#kategori_id_edit').empty();
                        $('#kategori_id_edit').append('<option value="">Pilih Kategori</option>');
                        $.each(data, function (key, value) {
                            if (value.kategori_id == param2) {
                                $('#kategori_id_edit').append('<option value="' + value
                                    .kategori_id + '" selected>' + value.nama_kategori +
                                    '</option>');
                            } else {
                                $('#kategori_id_edit').append('<option value="' + value
                                    .kategori_id + '">' + value.nama_kategori +
                                    '</option>');
                            }
                        });
                    }
                });
            }

            function setkategori(param1, param2) {
                $.ajax({
                    url: './getkategori/' + param1,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#kategori_id').empty();
                        $('#kategori_id').append('<option value="">Pilih Kategori</option>');
                        $.each(data, function (key, value) {
                            if (value.kategori_id == param2) {
                                $('#kategori_id').append('<option value="' + value
                                    .kategori_id + '" selected>' + value.nama_kategori +
                                    '</option>');
                            } else {
                                $('#kategori_id').append('<option value="' + value
                                    .kategori_id + '">' + value.nama_kategori +
                                    '</option>');
                            }
                        });
                    }
                });
            }

            function setBarangedit(param1, param2) {
                $.ajax({
                    url: './getBarang/' + param2,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#barang_code_edit').empty();
                        $('#barang_code_edit').append('<option value="">Pilih Barang</option>');
                        $.each(data, function (key, value) {
                            if (value.barang_id == param1) {
                                $('#barang_code_edit').append('<option value="' + value
                                    .barang_id + '" selected>' + value.nama_barang +
                                    '</option>');
                            } else {
                                $('#barang_code_edit').append('<option value="' + value
                                    .barang_id + '">' + value.nama_barang + '</option>');
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
                        $('#jumlah_stok').empty();
                        $('#jumlah_stok').attr('max',data[0].jumlah_barang);                      
                        $('#barang_code').empty();
                        $('#barang_code').append('<option value="">Pilih Barang</option>');                       
                        $.each(data, function (key, value) {
                            if (value.barang_id == param1) {
                                $('#barang_code').append('<option value="' + value
                                    .barang_id + '" selected>' + value.nama_barang +
                                    '</option>');
                            } else {
                                $('#barang_code').append('<option value="' + value
                                    .barang_id + '">' + value.nama_barang + '</option>');

                            }
                        $('#jumlah_stok').val(data[0].jumlah_barang);   
                   alert(data[0].jumlah_barang);
                                         
                        });
                    }
                });
            }
            $(document).on('click', '.details', function () {
                console.log($(this).data('pic'));
                $('#user_code_detail').val($(this).data('user_id'));
                $('#tgl_pengambilan').val($(this).data('tgl_pengambilan'));
                $('#nodofetiket_code_detail').val($(this).data('no_dof_etiket'));
                $('#nama_code_detail').val($(this).data('nama'));
                $('#barcode_detail').val($(this).data('barcode'));
                $('#kategori_barang').val($(this).data('nama_kategori'));
                $('#pic_code_detail').val($(this).data('pic'));
                var jenis_barang = $(this).data('jenis_barang');
                if (jenis_barang == 1) {
                    $('#jenis_code_detail').val('Consumable');
                } else {
                    $('#jenis_code_detail').val('Asset');
                }
                $('#jumlah_detail').val($(this).data('jumlah_barang_keluar'));
                $('#keterangan_code_detail').val($(this).data('keterangan'));



                //showmodal
                $('#modalInfo').modal('show');
            });



            @can(['barangkeluar-C'])
            $('#formmenus').submit(function (e) {
                e.preventDefault();
                var formData = new FormData($("#formmenus")[0]);
                // var formData = $('#formmenus').serializeArray(); // our data object
                var method = "POST";
           

                //var url = (menuID != "" || menuID != undefined) ? `./company/${menuID}/update` : `./company`;

                $.ajax({
                    type: method, // define the type of HTTP verb we want to use (POST for our form)
                    url: `./barangkeluar`, // the url where we want to POST
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
                    let form = document.forms.formmenus; // <form name="formmenus"> element
                    form.reset();
                    datatable.reload();

                }).fail(function (data) {
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        if ($(`input[name='${index}']`)) {
                            $(`input[name='${index}']`).addClass(`is-invalid`);
                            $(`input[name='${index}']`).after(
                                `<div class="invalid-feedback">${value}</div>`);
                        }
                        show_toastr('error', index, value);
                    });
                }).always(function () {
                    $('#saveMenu').attr('disabled', false).html(
                        "<i class='fa fa-save'></i> Save");
                });
            });
            @endcan
            
            @can(['barangkeluar-U'])
            $('#formmenusedit').submit(function (e) {
                e.preventDefault();
                var formData = new FormData($("#formmenusedit")[0]);
                // var formData = $('#formmenus').serializeArray(); // our data object
                var method = "POST";
                let menuID = $("#saveMenuedit").attr('data-id');

                //var url = (menuID != "" || menuID != undefined) ? `./company/${menuID}/update` : `./company`;

                $.ajax({
                    type: method, // define the type of HTTP verb we want to use (POST for our form)
                    url: '/barangkeluar/'+menuID+'/update', // the url where we want to POST
                    data: formData,
                    dataType: 'JSON', // what type of data do we expect back from the server
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $(`.form-control`).removeClass('is-invalid');
                        $(`.invalid-feedback`).remove();
                        $('#saveMenuedit').attr('disabled', true).html(
                            "<i class='fa fa-spinner fa-spin'></i> processing");
                    }
                }).done(function (data) {
                    $("#modalMenuEdit").modal('hide');
                    showtoastr('success', data.message);
                    $("#saveMenuedit").data("id", "");
                    $("#formmenusedit")[0].reset();
                    menuID = "";
                    let form = document.forms.formmenusedit; // <form name="formmenus"> element
                    form.reset();
                    datatable.reload();

                }).fail(function (data) {
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        if ($(`input[name='${index}']`)) {
                            $(`input[name='${index}']`).addClass(`is-invalid`);
                            $(`input[name='${index}']`).after(
                                `<div class="invalid-feedback">${value}</div>`);
                        }
                        show_toastr('error', index, value);
                    });
                }).always(function () {
                    $('#saveMenuedit').attr('disabled', false).html(
                        "<i class='fa fa-save'></i> Save");
                });
            });
            @endcan


            @can(['barangkeluar-C', 'barangkeluar-U'])
            $('#formreturn').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST", // define the type of HTTP verb we want to use (POST for our form)
                    url: './returnbarang/', // the url where we want to POST
                    data: {
                        'barang_keluar_id': $('#id_barang_keluar').val(),
                        'jumlah': $('#jumlahdikembalikan').val(),
                        'barang_id': $('#barang_id').val(),
                    },
                    dataType: 'JSON', // what type of data do we expect back from the server
                    // contentType: false,
                    // processData: false,
                    beforeSend: function () {
                        $(`.form-control`).removeClass('is-invalid');
                        $(`.invalid-feedback`).remove();
                        $('#saveMenu').attr('disabled', true).html(
                            "<i class='fa fa-spinner fa-spin'></i> processing");
                    }
                }).done(function (data) {
                    $("#modalInfo").modal('hide');
                    showtoastr('success', data.message);
                    $("#saveMenu").data("id", "");
                    $("#formreturn")[0].reset();
                    menuID = "";
                    let form = document.forms.formmenus; // <form name="formmenus"> element
                    form.reset();
                    // close modal
                    $('#modalReturn').modal('hide');
                    datatable.reload();
                }).fail(function (data) {
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        if ($(`input[name='${index}']`)) {
                            $(`input[name='${index}']`).addClass(`is-invalid`);
                            $(`input[name='${index}']`).after(
                                `<div class="invalid-feedback">${value}</div>`);
                        }
                        show_toastr('error', index, value);
                    });
                }).always(function () {
                    $('#saveMenu').attr('disabled', false).html(
                        "<i class='fa fa-save'></i> Save");
                });
            });
            @endcan

            @can('barangkeluar-D')
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
                                    url: './barangkeluar/' + $(this).data(
                                        'id'), // the url where we want to POST
                                })
                                .done(function (data) {
                                    showtoastr('success', data.message);
                                })
                                .fail(function (data) {
                                    show_toastr('error', data.responseJSON.status, data
                                        .responseJSON
                                        .message);
                                    $.each(data.responseJSON.messages, function (index, value) {
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

        });
        $('#export_bulanan').click(function () {
            $('#BulananExportkeluar').modal('show');
        });

        function modalTahunanExport() {
            $('#exportTahunankeluar').modal('show')
        }

        function modalBulananExport() {
            $('#BulananExportkeluar').modal('show')
        }

        $('.btn-export_excel').click(function () {
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
                url: './barangkeluar-export',
                type: "Post",
                data: {
                    tanggal_awal: $('#tgl_awal').val(),
                    tanggal_akhir: $('#tgl_akhir').val(),
                },
                success: function (result, status, xhr) {
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var filename = ('Laporan Keluar bulanan.xlsx');

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

        });

        $('.btn-export_pdf').on('click', function () {
            $.ajax({
                xhrFields: {
                    responseType: 'blob',
                },
                url: './barangkeluar-export-tahunan',
                type: "get",
                success: function () {
                    window.location.href = './barangkeluar-export-tahunan';
                }
            })
        })

    </script>

    @endsection
