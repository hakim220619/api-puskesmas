<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
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
        $data = DB::select("select i.*, u.name, u.nama_ortu, b.nama_bulan from imunisasi i, users u, bulan b where i.id_user=u.id and i.id_bulan=b.id");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function getGravikSiswa(Request $request)
    {
        $data = DB::select("select lp.bb_lahir, b.nama_bulan from list_penimbangan lp, users u, bulan b where lp.id_user=u.id and lp.id_bulan=b.id and lp.id_user = '$request->id' and lp.tahun = '$request->tahun' order by lp.id_bulan");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function getMonth(Request $request)
    {
        $data = DB::select("select * from bulan WHERE id NOT IN (SELECT id_bulan FROM list_penimbangan WHERE id_user = '$request->id_user' and tahun = '$request->tahun')");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function getMonthImunisasi(Request $request)
    {
        $data = DB::select("select * from bulan WHERE id NOT IN (SELECT id_bulan FROM imunisasi WHERE id_user = '$request->id_user' and tahun = '$request->tahun')");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function getPenimbanganByMonth($id)
    {
        $data = DB::select("select lp.*, u.name, b.nama_bulan from list_penimbangan lp, users u, bulan b where lp.id_user=u.id and lp.id_bulan=b.id and lp.id_user = '$id' order by lp.tahun desc");
        return response()->json([
            'success' => true,
            'message' => 'Data ',
            'data' => $data,
        ]);
    }
    function addPenimbangan(Request $request)
    {
        $data = [
            'id_user' => $request->id_user,
            'tahun' => $request->tahun,
            'id_bulan' => $request->id_bulan,
            'bb_lahir' => $request->bb_lahir,
            'tb_lahir' => $request->tb_lahir,
            'created_at' => now()
        ];
        DB::table('list_penimbangan')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert data',
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
        DB::table('list_penimbangan')->where('id', $request->id)->update($data);
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
            'tahun' => $request->tahun,
            'id_bulan' => $request->id_bulan,
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
    function updateImunisasi(Request $request)
    {
        $data = [
            'jenis_vaksin' => $request->jenis_vaksin,
            'tanggal_vaksin' => $request->tanggal_vaksin,
            'anak_ke' => $request->anak_ke,
            'jadwal_mendatang' => $request->jadwal_mendatang,
            'updated_at' => now()
        ];
        // dd($data);
        DB::table('imunisasi')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'updated data',
            'data' => $data,
        ]);
    }
    function deleteImunisasi(Request $request)
    {
        DB::table('imunisasi')->where('id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete data'
        ]);
    }
    public function exportPdf()
    {
        $data['users'] = DB::select("SELECT u.name, u.jenis_kelamin, u.nama_ortu, i.jenis_vaksin, (SELECT bb_lahir from list_penimbangan lp WHERE lp.id_user=u.id ORDER BY lp.id_bulan DESC LIMIT 1) as bb_lahir, (SELECT tb_lahir from list_penimbangan lp WHERE lp.id_user=u.id ORDER BY lp.id_bulan DESC LIMIT 1) as tb_lahir FROM users u, imunisasi i WHERE u.id=i.id_user");
        // dd($data);
        $pdf = PDF::loadView('pdfs.index', $data);
        $filename = 'Bayi' . '_' . date('mhs');
        $pdf->save(public_path("storage/pdf/" . $filename . ".pdf"));
        if ($pdf) {
            $response =  array(
                'success'   => true,
                'msg'       => "Download success",
                'file'      => asset('storage/pdf/' . $filename . '.pdf'),
                'file_name' =>  $filename
            );
            return response($response);
        } else {
            return response(array('msg' => 'There is no data to export.'));
        }
    }
    public function word(Request $request)
    {

        $getData = DB::select("SELECT u.id, k.pertanyaan, u.name, u.nik, u.jenis_kelamin, u.nama_ortu, u.tanggal_lahir, k.created_at FROM keluhan k, users u WHERE k.id_ortu=u.id and k.id = '$request->id' ORDER BY k.created_at DESC");
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path("storage/word/rujukan.docx"));
        $filename = 'Keluhan' . '_' . date('mhs');
        $templateProcessor->setValues([
            'nama' => $getData[0]->name,
            'nik' => $getData[0]->nik,
            'jenis_kelamin' => $getData[0]->jenis_kelamin,
            'nama_ortu' => $getData[0]->nama_ortu,
            'tanggal_lahir' => $getData[0]->tanggal_lahir,
            'keluhan ' => $getData[0]->pertanyaan,
        ]);

        header("Content-Disposition: attachment; filename=" . $filename . ".docx");

        $templateProcessor->saveAs(public_path("storage/word/" . $filename . ".docx"));


        if ($templateProcessor) {
            $response =  array(
                'success'   => true,
                'msg'       => "Download success",
                'file'      => asset('storage/word/' . $filename . '.docx'),
                'file_name' =>  $filename
            );
            return response($response);
        } else {
            return response(array('msg' => 'There is no data to export.'));
        }
    }
}
