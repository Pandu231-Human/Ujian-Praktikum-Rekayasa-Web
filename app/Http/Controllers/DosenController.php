<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $dosen = Dosen::all();
        return response()->json([
            'success' => true,
            'data' => $dosen
        ]);
    }

    public function show($id)
    {
        $dosen = Dosen::find($id);
        
        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Dosen tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dosen
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'nidn' => 'required|string|max:20|unique:dosen',
            'email' => 'required|email|max:50|unique:dosen'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dosen = Dosen::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dosen berhasil ditambahkan',
            'data' => $dosen
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);
        
        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Dosen tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|max:50',
            'nidn' => 'sometimes|string|max:20|unique:dosen,nidn,' . $id,
            'email' => 'sometimes|email|max:50|unique:dosen,email,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dosen->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dosen berhasil diupdate',
            'data' => $dosen
        ]);
    }

    public function destroy($id)
    {
        $dosen = Dosen::find($id);
        
        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Dosen tidak ditemukan'
            ], 404);
        }

        $dosen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dosen berhasil dihapus'
        ]);
    }
}
