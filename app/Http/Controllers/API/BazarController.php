<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BazarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BazarController extends Controller
{
    public function index()
    {
        $data = BazarModel::all();
        return response()->json([
            'message' => 'success ',
            'data' => $data
        ], Response::HTTP_OK);

        // return view('Data.bazar')->with('data', $data);
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
                $data->description = $request->input('description');
            }

            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal tambah data',
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
    }

    public function showById($id)
    {
        $data = BazarModel::findOrfail($id);

        return response()->json([
            'message' => 'success get data by id',
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'harga' => 'required',
            'gambar' => '',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'check your validation',
                'errors' => $validator->errors()
            ]);
        }

        $validated = $validator->validated();

        try {
            $data = BazarModel::findOrFail($request->id);
            $data->nama_menu = $request->input('nama_menu');
            $data->harga = $request->input('harga');
            if ($request->hasfile('gambar')) {
                $destination = 'uploads/menu/' . $data->gambar;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('gambar');
                $filename = $file->getClientOriginalName();
                $file->move('uploads/menu/', $filename);
                $data->gambar = $filename;
            }
            $data->description = $request->input('description');
            $data->update();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'code' => 402,
                'errors' => $th->getMessage()

            ]);
        }

        return response()->json([
            'message' => 'success update ',
            'data' => [
                'id' => $data->id,
                'data' => $data
            ]
        ], Response::HTTP_OK);
    }


    public function getGambar($filename)
    {
        $path = public_path('uploads/menu/' . $filename);
        if (file_exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = new Response($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else {
            return response()->json([
                'message' => 'File tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($id)
    {
        try {
            $data = BazarModel::find($id);
            $location = 'uploads/menu/' . $data->gambar;

            BazarModel::whereId($id)->delete();
            if ((File::exists($location))) {
                File::delete($location);
            }
            return response()->json([
                'message' => 'success delete data',

            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
