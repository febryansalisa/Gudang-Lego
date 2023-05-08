<?php

namespace App\Http\Controllers;

use App\Models\DetailBarangMasuk;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $data['menus'] = $this->getDashboardMenu();
        $data['menu']  = Menu::select('id', 'name')->get();
        $data['barang'] = Barang::select('barang_id', 'nama_barang')->get();
        return view('BarangMasuk', $data);
    }


    public function datatables()
    {
        $data = DB::table('detail_barang_masuks')
            ->join('barang_masuks', 'detail_barang_masuks.barang_masuk_id', '=', 'barang_masuks.barang_masuk_id')
            ->join('barangs', 'detail_barang_masuks.barang_id', '=', 'barangs.barang_id')
            ->select('barang_masuks.barang_masuk_id as id_barang_masuk', 'barang_masuks.*', 'detail_barang_masuks.*', 'barangs.*')
            ->where('barang_masuks.delete_mark', 0)
            ->get();
        return datatables()->of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_barang_masuk . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBarang">Edit</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_barang_masuk . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteLandingPage">Delete</a>';
                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $barang = DB::table('barangs')->where('barang_id', $request->barang_code)->first();
        $attributes = $request->only([
            'barang_code',
            'jumlah',
        ]);
        $roles = [

            'barang_code' => 'required',
            'jumlah' => 'required',
        ];


        $messages = [
            'required' => trans('messages.required'),
        ];

        $this->validators($attributes, $roles, $messages);

        DB::beginTransaction();
        try {
            // $data = DB::table('barang_masuks')->insert([

            //     'tanggal_barang_masuk' =>date('Y-m-d'),

            // ]);

            //         $id=$data->id;
            //      $data = DB::table('detail_barang_masuks')->insert([                    
            //          'barang_id' => $request->barang_code,
            //          'jumlah_barang_masuk' => $request->jumlah,
            //          'delete_mark' => 0,
            //      ]);
            //      //$data barangs include jumlah


            //         $data = DB::table('barangs')->where('barang_id', $request->barang_code)->update([
            //             'jumlah_barang' => $barang->jumlah_barang + $request->jumlah,

            //      ]);

            //      $data=array([

            //          'barang_id' => $request->barang_code,
            //          'jumlah_barang_masuk' => $request->jumlah,
            //          'delete_mark' => 0,

            //         ]);
            //     }


            // DB::commit();
            $barang_masuk = BarangMasuk::create([
                'tanggal_barang_masuk' => date('Y-m-d'),
                'delete_mark' => 0,
            ]);
            DetailBarangMasuk::create([
                'barang_masuk_id' => $barang_masuk->barang_masuk_id,
                'barang_id' => $request->barang_code,
                'jumlah_barang_masuk' => $request->jumlah,
                'delete_mark' => 0,
            ]);
            DB::table('barangs')->where('barang_id', $request->barang_code)->update([
                'jumlah_barang' => $barang->jumlah_barang + $request->jumlah,
            ]);
            DB::commit();
            $response = responseSuccess(trans("messages.create-success"));
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            $response = responseFail(trans("messages.create-fail"), $th->getMessage());
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function show($id)
    {
        // dd($id);
        $attributes['barang_masuk_id'] = $id;

        $roles = [
            'barang_masuk_id' => 'required | exists:barang_masuks,barang_masuk_id',
        ];

        $messages = [
            'required' => trans('messages.required'),
            'exists'   => trans('messages.exists'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data     = BarangMasuk::join('detail_barang_masuks', 'barang_masuks.barang_masuk_id', '=', 'detail_barang_masuks.barang_masuk_id')
            ->join('barangs', 'detail_barang_masuks.barang_id', '=', 'barangs.barang_id')
            ->where('barang_masuks.barang_masuk_id', $id)
            ->get();
        $response = responseSuccess(trans("messages.read-success"), $data);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function edit($id)
    {
        $query   = BarangMasuk::find($id);
        $response = responseSuccess(trans("messages.read-success"), $query);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        //
    }

    public function update($id, Request $request)
    {

        $attributes = $request->only([
            'barang_code',
            'jumlah',
            'delete_mark',
        ]);



        $roles = [
            'barang_code' => 'required',
            'jumlah' => 'required',
            'delete_mark' => 'required',

        ];

        $messages = [
            'required' => trans('messages.required'),
            'unique'   => trans('messages.unique'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data = $this->findDataWhere(BarangMasuk::class, ['barang_masuk_id' => $id]);

        DB::beginTransaction();
        try {
            $data->update([

                'barang_code' => $request->barang_code,
                'jumlah' => $request->jumlah,
                'delete_mark' => $request->delete_mark,
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

        BarangMasuk::destroy($id);
        $response = responseSuccess(trans('message.delete-success'));
        return response()->json($response, 200);
    }
    public function getBarang($jenis_code)
    {
        $data = Barang::where('jenis_barang', $jenis_code)->get();
        return response()->json($data);
    }
}
