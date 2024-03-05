<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluhanController extends Controller
{
    public function keluhan($id) {
        $data = DB::table('keluhan')->where('id_ortu', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    public function listKeluhan() {
        $data = DB::select("select k.*, u.name, u.nik from keluhan k, users u WHERE k.id_ortu=u.id GROUP BY k.id_ortu");
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);

    }
    public function listKeluhanById($id) {
        $data = DB::select("select k.*, u.name, u.nik from keluhan k, users u WHERE k.id_ortu=u.id and k.id_ortu = '$id'");
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);

    }
    
    function addKeluhan(Request $request) {
        $data = [
            'id_admin' => $request->id_admin,
            'id_ortu' => $request->id_ortu,
            'pertanyaan' => $request->pertanyaan,
            'created_at' => now()
        ];
        // dd($data);
        DB::table('keluhan')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
    function addJawaban(Request $request) {
        $data = [
            'id_admin' => $request->id_admin,
            'id_ortu' => $request->id_ortu,
            'jawaban' => $request->jawaban,
            'created_at' => now()
        ];
        // dd($data);
        DB::table('keluhan')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
}
