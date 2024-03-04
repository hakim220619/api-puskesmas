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
    function addMessage(Request $request)  {
        dd($request->all());
    }
    
}
