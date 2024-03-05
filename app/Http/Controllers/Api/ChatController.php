<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function messages() {
        $request = request();
        $data = DB::table('konsultasi')->where('id_admin', $request->id_admin)->where('id_ortu', $request->id_ortu)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);

    }
    public function listKonsultasi() {
        $data = DB::select("select k.*, u.name, u.nik from konsultasi k, users u WHERE k.id_ortu=u.id GROUP BY k.id_ortu");
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);

    }
    function addMessage(Request $request)  {
        // dd(request()->user()->role);
        $data = [
            'id_admin' => $request->id_admin,
            'id_ortu' => $request->id_ortu,
            'msg' => $request->msg,
            'flag' => $request->role == 1 ? 1 : 2,
            'created_at' => now()
        ];
        // dd($data);
        DB::table('konsultasi')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
    
}
