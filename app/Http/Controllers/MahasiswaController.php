<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function __construct()
 {
$this->middleware('auth:api');
 }
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return response()->json([
            'success' => true,
            'data' => $mahasiswa
        ]);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mahasiswa
        ]);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:50',
        'nim' => 'required|string|max:20|unique:mahasiswa',
        'email' => 'required|email|max:50|unique:mahasiswa'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $mahasiswa = Mahasiswa::create($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Mahasiswa berhasil ditambahkan',
        'data' => $mahasiswa
    ], 201);
}

    public function update(Request $request, $id)
{
    $mahasiswa = Mahasiswa::find($id);
    
    if (!$mahasiswa) {
        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa tidak ditemukan'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'nama' => 'sometimes|string|max:50',
        'nim' => 'sometimes|string|max:20|unique:mahasiswa,nim,'.$id,
        'email' => 'sometimes|email|max:50|unique:mahasiswa,email,'.$id
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $mahasiswa->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Mahasiswa berhasil diupdate',
        'data' => $mahasiswa
    ]);
}
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil dihapus'
        ]);
    }
}