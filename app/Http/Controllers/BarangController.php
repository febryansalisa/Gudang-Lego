<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $data['data'] = Barang::orderBy('nama_barang', 'asc')->where('delete_mark', 0)->get();
        $data['menus'] = $this->getDashboardMenu();
        $data['menu']  = Menu::select('id', 'name')->get();
        $data['kategori'] = DB::table('kategoris')->get();
        return view('Barang', $data);
    }

    public function datatables()
    {
        // $data = Barang::orderBy('nama_barang', 'asc')->where('delete_mark', 0)->get();
        $data = DB::table('barangs')
        ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
        ->where('barangs.delete_mark', 0)
        ->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('jenis_barang', function ($row) {
                $jenis = $row->jenis_barang;
                if ($jenis == 1) {
                    $jenis = 'Consumable';
                } else if ($jenis == 2) {
                    $jenis = 'Aset';
                }
                return $jenis;
            })
            ->addColumn('nama_kategori', function ($row) {
                $kategori = $row->nama_kategori;
                if ($kategori == '') {
                    $kategori = 'Belum dikategorikan';
                } else {
                    $kategori = $row->nama_kategori;
                }
                return $kategori;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBarang">Edit</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteLandingPage">Delete</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_id . '" data-nama="' . $row->nama_barang.'" data-barcode="'.$row->barcode_barang.'" data-jenis_barang="'.$row->jenis_barang.'" data-keterangan_barang="'.$row->keterangan_barang.'" data-original-title="Detail" class="btn btn-info btn-sm detailLandingPage">Detail</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $attributes = $request->only([
            'barang_name',
            'barcode',
            'keterangan_code',
            'kategori_id', // Menambahkan field kategori_barang
        ]);
        $roles = [
            'barang_name' => 'required',
            'barcode' => 'required|unique:barangs,barcode_barang',
            'keterangan_code' => 'required',
            'kategori_id' => 'required', // Validasi untuk kategori_barang
        ];
        $messages = [
            'required' => trans('messages.required'),
            'unique' => trans('messages.unique'),
        ];

        $this->validators($attributes, $roles, $messages);


        DB::beginTransaction();
        try {
            $data = Barang::create([
                'user_id' => Auth::user()->id,
                'nama_barang' => $request->barang_name,
                'kategori_id' => $request->kategori_id,
                'barcode_barang' => $request->barcode,
                'keterangan_barang' => $request->keterangan_code,
                'kategori_barang' => $request->kategori_code, // Menambahkan kolom kategori_barang
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
        $attributes['barang_id'] = $id;
        $roles = [
            'barang_id' => 'required|exists:barangs,barang_id',
        ];
        $messages = [
            'required' => trans('messages.required'),
            'exists' => trans('messages.exists'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data = $this->findDataWhere(Barang::class, ['barang_id' => $id]);
        $response = responseSuccess(trans("messages.read-success"), $data);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        return $id;
    }

    public function edit($id)
    {
        $query = Barang::find($id);
        $response = responseSuccess(trans("messages.read-success"), $query);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        //
    }

    public function update($id, Request $request)
    {

        $attributes = $request->only([
            'user_code',
            'barang_name',
            'keterangan_code',
            'kategori_id', // Menambahkan field kategori_barang
        ]);

        $roles = [
            'user_code' => 'required | exists:users,id',
            'barang_name' => 'required',
            'keterangan_code' => 'required',
            'kategori_id' => 'required', // Validasi untuk kategori_barang
        ];

        $messages = [
            'required' => trans('messages.required'),
            'unique' => trans('messages.unique'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data = $this->findDataWhere(Barang::class, ['barang_id' => $id]);

        DB::beginTransaction();
        try {
            $data->update([
                'nama_barang' => $request->barang_name,
                'user_id' => $request->user_code,
                'keterangan_barang' => $request->keterangan_code,
                'kategori_barang' => $request->kategori_code, // Menambahkan kolom kategori_barang
                'updated_at' => now(),
            ]);
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
            DB::table('barangs')->where('barang_id', $id)->update([
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
}
