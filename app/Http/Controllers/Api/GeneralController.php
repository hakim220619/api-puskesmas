<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    function listUsers() {
        $data = DB::select("select * from users where role = '2'");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function updatepenimbangan(Request $request) {
        // dd($request->all());
        $data = [
            'bb_lahir' => $request->bb_lahir,
            'tb_lahir' => $request->tb_lahir,
            'updated_at' => now()
        ];
        // dd($data);
        DB::table('users')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
}
