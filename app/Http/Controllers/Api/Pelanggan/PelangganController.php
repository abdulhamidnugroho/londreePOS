<?php

namespace App\Http\Controllers\API\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pelanggan\TambahPelangganRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ApiResponser;
use App\Pelanggan;
use App\Pelanggan_Kios;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listpelanggan(Request $request)
    {
        if (isset($request->offset) && isset($request->limit)) {
            $offset = $request->offset;
            $limit = $request->limit;
		} else {
			$offset = 0;
            $limit = 1844673709559592498939942599; // Angka terbesar dalam type BigInt - Sc: MySQL 5.x Docs
		}

		if (isset($request->keyword)) {
			$strKeyword = $request->keyword;
		} else {
			$strKeyword = '';
        }
        
        $pelanggan = DB::table('pelanggan')
                    ->join('pelanggan_kios', 'pelanggan.id', '=', 'pelanggan_kios.pelanggan_id')
                    ->select('pelanggan.*')
                    ->where('pelanggan_kios.owner_id', $request->id)
                    ->where('pelanggan.trash', 0)
                    ->where('pelanggan.nama', 'like', '%' . $strKeyword . '%')
                    ->where('pelanggan.id', 'like', '%' . $strKeyword . '%')
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy('pelanggan.id', 'desc')
                    ->get();
          
        return $this->showAll($pelanggan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tambahpelanggan(TambahPelangganRequest $request)
    {
        if ($request->password){
            $password = bcrypt($request->password);
        } else {
            $password = bcrypt('12345');
        }

        if  (isset($request->email) AND isset($request->telepon)){
            $message = '(dengan data email & telepon)';
        } else if (isset($request->email)){
            $message = '(dengan data email)';
        } else if (isset($request->telepon)){
            $message = '(dengan data telepon)';
        } else if (!$request->email || !$request->telepon){
            $message = '(tanpa data email & telepon';
        }

        try {
            $pelanggan = Pelanggan::insert([
                'admin_id' => Auth::user()->id,
                'nama' => $request->nama, 
                'alamat' => $request->alamat,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'password' => bcrypt($request->password),
                'saldo_dompet' => 0,
                'last_update' => date("Y-m-d H:i:s"),
            ]);

            $id = DB::getPdo()->lastInsertId();

            $pelanggan_kios = Pelanggan_Kios::insert([
                'owner_id' => Auth::user()->id,
                'pelanggan_id' => $id
            ]);

            $data = DB::table('pelanggan')->where('id', $id)->first();

        } catch(\Exeception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Error: Gagal menambah pelanggan. - {$exception->getMessage()}"
            ], 500);
        }

        return response([
            'status' => 'sukses menambah pelanggan'. $message,
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
