<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BarangController extends Controller
{
    public function index()
    {
        $data['data'] = Barang::orderBy('nama_barang', 'asc')->where('delete_mark', 0)->get();
        $data['menus'] = $this->getDashboardMenu();
        $data['menu']  = Menu::select('id', 'name')->get();
        $data['kategori'] = DB::table('kategoris')->get();
        return view('barang', $data);
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
            ->addColumn('gambark', function ($row) {
                $gambar = $row->gambar;
                $location = public_path().'/file_barang';
                if ($gambar == '') {
                    $gambar = 'Belum ada gambar';
                } else {
                    $gambar = '<img src="' . asset('file_barang/' . $gambar) . '" width="100px" height="100px">';
                }
                return $gambar;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBarang">Edit</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->barang_id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteLandingPage">Delete</a>';
                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . 
                $row->barang_id . '" data-nama="' . $row->nama_barang.'" data-barcode="'.
                $row->barcode_barang.'" data-jenis_barang="'.$row->jenis_barang.'" data-nama_kategori="'
                .$row->nama_kategori.'" data-gambar="file_barang/'.$row->gambar.'"
                data-keterangan_barang="'.$row->keterangan_barang.'" data-original-title="Detail" 
                class="btn btn-info btn-sm detailLandingPage">Detail</a>';
                return $btn;
            })
            ->rawColumns(['action', 'gambark'    ])
            ->make(true);
    }

    public function store(Request $request)
    {
        $attributes = $request->only([
            'barang_name',
            'barcode',
            'keterangan_code',
            'kategori_id', // Menambahkan field kategori_barang
            'gambar',
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
        $file = $request->file('gambar');
        
        if (empty($file)) {
            return response()->json(['message' => 'File tidak boleh kosong'], 500);
        } else {
            $nama_file = null;
        
            if (!is_null($file) && $file->isValid()) {
                $nama_file = rand() . $file->getClientOriginalName();
                $file->move('file_barang', $nama_file);
            }
        }
        
        
        

       
        

        DB::beginTransaction();
        try {
            $data = Barang::create([
                'user_id' => Auth::user()->id,
                'nama_barang' => $request->barang_name,
                'kategori_id' => $request->kategori_id,
                'barcode_barang' => $request->barcode,
                'gambar' => $nama_file, 
                'keterangan_barang' => $request->keterangan_code,
                'kategori_barang' => $request->kategori_code, // Menambahkan kolom kategori_barang
                'jumlah_barang' => 0, // Menambahkan kolom jumlah_barang dengan nilai default '0
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

        // dd($request->all());
        $attributes = $request->only([
            'user_code',
            'barang_name',
            'keterangan_code',
            'kategori_id', // Menambahkan field kategori_barang
            'barcode',
            'gambar'
        ]);

        $roles = [
            'user_code' => 'required | exists:users,id',
            'barang_name' => 'required',
            'keterangan_code' => 'required',
            'kategori_id' => 'required', // Validasi untuk kategori_barang
            'barcode' => 'required|unique:barangs,barcode_barang,' . $id . ',barang_id',
        ];

        $messages = [
            'required' => trans('messages.required'),
            'unique' => trans('messages.unique'),
        ];

        $this->validators($attributes, $roles, $messages);

        $data = $this->findDataWhere(Barang::class, ['barang_id' => $id]);

        $file = $request->file('gambar');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_barang', $nama_file);

        DB::beginTransaction();
        try {
            $data->update([
                'nama_barang' => $request->barang_name,
                'user_id' => $request->user_code,
                'keterangan_barang' => $request->keterangan_code,
                'kategori_id' => $request->kategori_id, // Menambahkan kolom kategori_barang
                'barcode_barang' => $request->barcode,
                'gambar' => $nama_file,
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

    public function images(Request $request){
        $file = $request->file('gambar');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_barang', $nama_file);
        return response()->json(['location' => asset('file_barang/' . $nama_file)]);
    }

  
  
    // public function downloadTemplate(): BinaryFileResponse
    // {
    //     return response()->download(public_path('templatebarang.xlsx'));
    // }
    
    public function downloadTemplate(): BinaryFileResponse
    {
        //export templateEXport
        return Excel::download(new TemplateExport, 'templatebarang.xlsx');
       
    }


    public function import(Request $request)
    {
        $request->validate([
            'fileimportupload' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('fileimportupload');
        $nama_file = rand() . $file->getClientOriginalName();
        // move to public folder
        $file->move('file_barang', $nama_file);
        Excel::import(new BarangImport, public_path('/file_barang/' . $nama_file));
        return response()->json(['message' => 'Import successfully'], 200);
    }


    
}
