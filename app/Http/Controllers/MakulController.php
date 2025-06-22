<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Makul;
use Illuminate\Support\Facades\Validator;

class MakulController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $makul = Makul::all();
        return response()->json([
            'success' => true,
            'data' => $makul
        ]);
    }

    public function show($id)
    {
        $makul = Makul::find($id);
        
        if (!$makul) {
            return response()->json([
                'success' => false,
                'message' => 'Makul tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $makul
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'kode' => 'required|string|max:20|unique:makul',
            'sks' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $makul = Makul::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Makul berhasil ditambahkan',
            'data' => $makul
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $makul = Makul::find($id);
        
        if (!$makul) {
            return response()->json([
                'success' => false,
                'message' => 'Makul tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|max:50',
            'kode' => 'sometimes|string|max:20|unique:makul,kode,' . $id,
            'sks' => 'sometimes|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $makul->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Makul berhasil diupdate',
            'data' => $makul
        ]);
    }

    public function destroy($id)
    {
        $makul = Makul::find($id);
        
        if (!$makul) {
            return response()->json([
                'success' => false,
                'message' => 'Makul tidak ditemukan'
            ], 404);
        }

        $makul->delete();

        return response()->json([
            'success' => true,
            'message' => 'Makul berhasil dihapus'
        ]);
    }
}
