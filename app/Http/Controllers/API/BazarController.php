<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BazarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
