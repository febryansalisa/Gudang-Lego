<?php

namespace App\Http\Controllers;

use App\Exports\BarangAssetsSheet;
use App\Exports\BarangConsummableSheet;
use App\Exports\ExportMultipleSheets;
use App\Exports\Exportxls;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\DetailBarangKeluar;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $data['menus'] = $this->getDashboardMenu();
        $data['menu']  = Menu::select('id', 'name')->get();
        $data['barang'] = Barang::select('barang_id', 'nama_barang')->get();
        $data['kategori'] = DB::table('kategoris')->get();
        return view('barangkeluar', $data);
    }

    public function datatables()
    {
        $data = DB::table('barang_keluars')
            ->join('detail_barang_keluars', 'barang_keluars.barang_keluar_id', '=', 'detail_barang_keluars.barang_keluar_id')
            ->join('barangs', 'detail_barang_keluars.barang_id', '=', 'barangs.barang_id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->where('barang_keluars.delete_mark', 0)
            ->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_keluar_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBarang">Edit</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_keluar_id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteLandingPage">Delete</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_keluar_id . '" data-original-title="return" class="return btn btn-info btn-sm returnBarang">Return Barang</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_keluar_id . '" data-user_id="' . $row->user_id . '" data-tgl_pengambilan="' . $row->tgl_pengambilan . '" data-no_dof_etiket="' . $row->no_dof_etiket . '" data-pic= "' . $row->pic . '" data-nama="' . $row->nama_barang . '" data-barcode="' . $row->barcode_barang . '" data-jenis_barang="' . $row->jenis_barang . '" data-keterangan="' . $row->keterangan . '" data-jumlah_barang_keluar="' . $row->jumlah_barang_keluar . '" data-keterangan_barang="' . $row->keterangan_barang . '" data-nama_kategori="' . $row->nama_kategori . '" data-original-title="Detail" class="btn btn-info btn-sm detailLandingPage">Detail</a>';
                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $barang = Barang::where('barang_id', $request->barang_code)->first();
        if ($barang->jumlah_barang < $request->jumlah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah barang tidak mencukupi',
            ]);
        }

        $attributes = $request->only([
            'nodofetiket_code',
            'keterangan_code',
            'barang_code',
            'jumlah',
            'pic_code',
        ]);
        $roles = [
            'nodofetiket_code' => 'required',
            'keterangan_code' => 'required',
            'barang_code' => 'required',
            'jumlah' => 'required',
            'pic_code' => 'required',
        ];
        $messages = [
            'required' => trans('messages.required'),
        ];

        $this->validators($attributes, $roles, $messages);

        DB::beginTransaction();
        try {
            $data = DB::table('barang_keluars')->insert([
                'user_id' => Auth::user()->id,
                'no_dof_etiket' => $request->nodofetiket_code,
                'tgl_pengambilan' => date('Y-m-d'),
                'keterangan' => $request->keterangan_code,
                'pic' => $request->pic_code,
                'delete_mark' => 0,
            ]);
            if ($data) {
                $barang_keluar_id = DB::getPdo()->lastInsertId();
                $data = DB::table('detail_barang_keluars')->insert([
                    'barang_keluar_id' => $barang_keluar_id,
                    'barang_id' => $request->barang_code,
                    'jumlah_barang_keluar' => $request->jumlah,
                    'delete_mark' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $data = DB::table('barangs')->where('barang_id', $request->barang_code)->update([
                    'jumlah_barang' => $barang->jumlah_barang - $request->jumlah,
                ]);

                $data = array([
                    'barang_keluar_id' => $barang_keluar_id,
                    'barang_id' => $request->barang_code,
                    'jumlah_barang_keluar' => $request->jumlah,
                    'delete_mark' => 0,
                ]);
            }
            DB::commit();
            $response = responseSuccess(trans("messages.create-success"), $data);
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            $response = responseFail(trans("messages.create-fail"), $th->getMessage());
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function show($id)
    {
        $attributes['barang_keluar_id'] = $id;

        $roles = [
            'barang_keluar_id' => 'required|exists:barang_keluars,barang_keluar_id',

        ];
        $messages = [
            'required' => trans('messages.required'),
            'exists'   => trans('messages.exists'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data     = DB::table('detail_barang_keluars')->where('detail_barang_keluars.barang_keluar_id', $id)
            ->join('barangs', 'detail_barang_keluars.barang_id', '=', 'barangs.barang_id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->join('barang_keluars', 'detail_barang_keluars.barang_keluar_id', '=', 'barang_keluars.barang_keluar_id')
            ->get();
        $response = responseSuccess(trans("messages.read-success"), $data);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function edit($id)
    {
        $query   = DetailBarangKeluar::find($id);
        $response = responseSuccess(trans("messages.read-success"), $query);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        //
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $attributes = $request->only([
            // 'user_code_edit',
            'nodofetiket_code',
            'jumlah_edit',
            'keterangan_code_edit',
            'pic_code_edit',

        ]);

        $roles = [
            // 'user_code_edit' => 'required | exists:users,id',
            'nodofetiket_code' => 'required',
            'jumlah_edit' => 'required',
            'keterangan_code_edit' => 'required',
            'pic_code_edit' => 'required',
        ];

        $messages = [
            'required' => trans('messages.required'),
            'unique'   => trans('messages.unique'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data = $this->findDataWhere(BarangKeluar::class, ['barang_keluar_id' => $id]);

        DB::beginTransaction();
        try {
            $data->update([
                // 'user_id' => $request->user_code_edit,
                'no_dof_etiket' => $request->nodofetiket_code,
                'keterangan' => $request->keterangan_code_edit,
                'pic' => $request->pic_code_edit,
            ]);
            $detailbarangkeluar = DetailBarangKeluar::where('barang_keluar_id', $id)->first();
            $barang = Barang::where('barang_id', $detailbarangkeluar->barang_id)->first();
            $data_old = DetailBarangKeluar::where('barang_keluar_id', $id)->first();
            $data = DetailBarangKeluar::where('barang_keluar_id', $id)->update([
                'jumlah_barang_keluar' => $request->jumlah_edit,
            ]);
            $data = Barang::where('barang_id', $detailbarangkeluar->barang_id)->update([
                'jumlah_barang' => $barang->jumlah_barang + $data_old->jumlah_barang_keluar - $request->jumlah_edit,
            ]);
            $data = [
                'barang_keluar_id' => $id,
                // 'user_id' => $request->user_code_edit,
                'no_dof_etiket' => $request->nodofetiket_code,
                'jumlah_barang_keluar' => $request->jumlah_edit,
                'keterangan' => $request->keterangan_code_edit,
                'pic' => $request->pic_code_edit,
            ];
            DB::commit();
            $response = responseSuccess(trans("messages.update-success"), $data);
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            DB::rollback();
            $response = responseFail(trans("messages.update-fail"), $e->getMessage());
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('barang_keluars')->where('barang_keluar_id', $id)->update([
                'delete_mark' => 1,
            ]);
            $response = responseSuccess(trans('message.delete-success'));
            DB::commit();
            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getBarang($kategori_id)
    {
        $data = Barang::where('kategori_id', $kategori_id,)
            ->where('delete_mark', 0)
            ->get();
        return response()->json($data);
    }

    public function exportTanggalBarangKeluar(Request $request)
    {
        // dd($request->all());


        $data =  DB::table('barang_keluars')
            ->join('detail_barang_keluars', 'barang_keluars.barang_keluar_id', '=', 'detail_barang_keluars.barang_keluar_id')
            ->join('barangs', 'detail_barang_keluars.barang_id', '=', 'barangs.barang_id')
            ->join('users', 'barang_keluars.user_id', '=', 'users.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->leftJoin('return_barangs', 'barang_keluars.barang_keluar_id', '=', 'return_barangs.barang_keluar_id')
            ->leftJoin('detail_return_barangs', 'return_barangs.return_id', '=', 'detail_return_barangs.return_id')
            ->whereBetween('tgl_pengambilan', [$request->tanggal_awal, $request->tanggal_akhir])
            ->select(
                "barang_keluars.tgl_pengambilan",
                "return_barangs.waktu_return",
                "users.first_name",
                "barang_keluars.no_dof_etiket",
                "barangs.nama_barang",
                "kategoris.jenis_barang",
                "kategoris.nama_kategori",
                "detail_barang_keluars.jumlah_barang_keluar",
                "detail_return_barangs.jumlah_barang_return",
                "barangs.jumlah_barang",
                "barang_keluars.keterangan",
                "barang_keluars.pic"
            )
            ->get();


        $collect = $data->map(function ($item) {
            $item->jenis_barang = $item->jenis_barang == 1 ? "consummable" : "asset";
            return $item;
        });

        $consummableData = $data->filter(function ($item) {
            return $item->jenis_barang == "consummable";
        });

        $assetData = $data->filter(function ($item) {
            return $item->jenis_barang == "asset";
        });

        $sheets = [
            new BarangConsummableSheet($consummableData),
            new BarangAssetsSheet($assetData),
        ];
        $column =[
            "tgl_pengambilan",
            "waktu_return",
            "first_name",
            "Nomor Pesanan",
            "pic",
            "nama_barang",
            "jenis_barang",
            "nama_kategori",
            "jumlah_barang_keluar",
            "jumlah_barang_return",
            "jumlah_barang",
            "keterangan",
        ];

        return Excel::download(new ExportMultipleSheets($sheets), 'Laporan Barangkeluar.xlsx');
    }

    public function exportTahunBarangKeluar(): BinaryFileResponse
    {
        $year_now = date('Y');

        $data =  DB::table('barang_keluars')
            ->join('detail_barang_keluars', 'barang_keluars.barang_keluar_id', '=', 'detail_barang_keluars.barang_keluar_id')
            ->join('barangs', 'detail_barang_keluars.barang_id', '=', 'barangs.barang_id')
            ->join('users', 'barang_keluars.user_id', '=', 'users.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->leftJoin('return_barangs', 'barang_keluars.barang_keluar_id', '=', 'return_barangs.barang_keluar_id')
            ->leftJoin('detail_return_barangs', 'return_barangs.return_id', '=', 'detail_return_barangs.return_id')
            ->where('tgl_pengambilan', 'like', '%' . $year_now . '%')
            ->select(
                "barang_keluars.tgl_pengambilan",
                "return_barangs.waktu_return",
                "users.first_name",
                "barang_keluars.no_dof_etiket",
                "barang_keluars.pic",
                "barangs.nama_barang",
                "kategoris.jenis_barang",
                "kategoris.nama_kategori",
                "detail_barang_keluars.jumlah_barang_keluar",
                "detail_return_barangs.jumlah_barang_return",
                "barangs.jumlah_barang",
                "barang_keluars.keterangan",

            )
            ->get();


        $collect = $data->map(function ($item) {
            $item->jenis_barang = $item->jenis_barang == 1 ? "consummable" : "asset";
            return $item;
        });

        $consummableData = $data->filter(function ($item) {
            return $item->jenis_barang == "consummable";
        });

        $assetData = $data->filter(function ($item) {
            return $item->jenis_barang == "asset";
        });

        $sheets = [
            new BarangConsummableSheet($consummableData),
            new BarangAssetsSheet($assetData),
        ];

        return Excel::download(new ExportMultipleSheets($sheets), 'Laporan Barangkeluar.xlsx');
    }
}
