<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BazarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BazarController extends Controller
{
    public function index()
    {
        $data = BazarModel::all();
        return response()->json([
            'message' => 'success ',
            'data' => $data
        ], Response::HTTP_OK);

        return view('Data.bazar')->with('data', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required',
            'description' => 'required'
        ]);


        if ($validator->fails()) {
            // $msg = $validator->errors()->first();
            // Alert::error('Gagal', $msg);
            // return redirect()->back();

            return response()->json([
                'message' => 'failed',
                'errors' => $validator->errors()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $validated = $validator->validated();

        try {
            $data = new BazarModel($validated);
            $data->nama_menu = $request->input('nama_menu');
            $data->harga = $request->input('harga');
            if ($request->hasfile('gambar')) {
                $file = $request->file('gambar');
                $filename = $file->getClientOriginalName();
                $file->move('uploads/menu/', $filename);
                $data->gambar = $filename;
            }
            $data->gambar = $request->input('gambar');
            $data->description = $request->input('description');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal',
                'errors' => $th->getMessage()
            ]);
        }




        return response()->json([
            'message' => 'success tambah data',
            'data' => [
                'id' => $data->id,
                'data' => $data
            ]
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
