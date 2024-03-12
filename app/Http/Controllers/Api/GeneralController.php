<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GeneralController extends Controller
{
    function listUsers()
    {
        $data = DB::select("select * from users where role = '2'");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function liestUserById()
    {
        $data = DB::select("select * from users where role = '2' and id = '" . request()->user()->id . "'");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function liestImunisasiById()
    {
        $data = DB::select("select * from imunisasi where id_user = '" . request()->user()->id . "'");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function listImunisasiAll()
    {
        $data = DB::select("select i.*, u.name, u.nama_ortu from imunisasi i, users u where i.id_user=u.id");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function updatepenimbangan(Request $request)
    {
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
    function editUsersOrtu(Request $request)
    {
        // dd($request->all());
        if ($request->password == 'asd') {
            $data = [
                'name' => Str::upper($request->name),
                'nik' => $request->nik,
                'email' => $request->email,
                'role' => 2,
                'address' => $request->address,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_ortu' => $request->nama_ortu,
                'updated_at' => now(),
            ];
        } else {
            $data = [
                'name' => Str::upper($request->name),
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
                'address' => $request->address,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_ortu' => $request->nama_ortu,
                'updated_at' => now(),
            ];
        }

        // dd($data);
        DB::table('users')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
    function addImunisasi(Request $request)
    {
        $data = [
            'id_user' => $request->id_user,
            'jenis_vaksin' => $request->jenis_vaksin,
            'tanggal_vaksin' => $request->tanggal_vaksin,
            'anak_ke' => $request->anak_ke,
            'jadwal_mendatang' => $request->jadwal_mendatang,
            'created_at' => now()
        ];
        // dd($data);
        DB::table('imunisasi')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
            'data' => $data,
        ]);
    }
    function deleteImunisasi(Request $request) {
        DB::table('imunisasi')->where('id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete data'
        ]);
    }
}
