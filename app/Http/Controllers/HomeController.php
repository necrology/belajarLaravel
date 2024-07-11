<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataBarang;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = dataBarang::query();
            return DataTables::of($query)->addIndexColumn()
                ->addColumn('action', function (DataBarang $query) {
                    $actionBtn =
                        '<a href="javascript:void(0)" data-id="' . $query->id . '" id="btn-edit" title="Edit Barang" class="btn btn-link btn-primary btn-lg"> <i class="fa fa-edit"></i></a> 
                        <a href="javascript:void(0)" data-id="' . $query->id . '" id="btn-delete" class="btn btn-link btn-danger" title="Hapus Data"><i class="fa fa-times"></i></a>';
                    return $actionBtn;
                })->rawColumns(['action'])->make();
        }
        return view('home/home');
    }

    public function insert(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_barang'     => 'required',
            'qty'   => 'required',
            'harga'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = DataBarang::create([
            'nama_barang'     => $request->nama_barang,
            'qty'   => $request->qty,
            'harga'   => $request->harga,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }

    public function delete($id)
    {
        //delete post by ID
        DataBarang::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Barang Berhasil Dihapus!.',
        ]);
    }

    public function getData($id)
    {
        $response = DataBarang::where('id', $id)->get();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Barang',
            'data'    => $response
        ]);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_barang'     => 'required',
            'qty'   => 'required',
            'harga'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = DataBarang::where('id', $id)->update([
                'nama_barang'     => $request->nama_barang,
                'qty'   => $request->qty,
                'harga'   => $request->harga,
            ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data'    => $post
        ]);
    }
}
