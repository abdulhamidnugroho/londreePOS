<?php

namespace App\Http\Controllers\API\Transaksi;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaksi $transaksi)
    {
        $date = Carbon::now();
        $kios = DB::table('kios')->where('id', $request->id_kios)->first();
        
        $token = $request->bearerToken();
        
        $diskon = $request->total - $request->diskon;
        $count = DB::table('transaksi')
                     ->select(DB::raw('count(id) as ids'))
                     ->where('pelanggan', '=', $request->id_pelanggan)
                     ->get();

        if (!$request || !$token)
        {
            return $this->errorResponse('JSON Data Request dan Token tidak boleh kosong', 400);
        }
        

        if (isset($request->pengerjaan_nota_id) && isset($request->pengerjaan_nota_nama))
        {
            if (isset($request->id))
            {
                if (isset($request->diskon))
                {
                    $data = [
                        'id' => $request->id,
                        'owner_id' => $kios->id_owner,
                        'pelanggan_id' => $request->id_pelanggan,
                        'pengerjaan_nota_id' => $request->pengerjaan_nota_id,
						'pengerjaan_nota_nama' => $request->pengerjaan_nota_nama,
						'status_order' => $request->status_order,
						'tgl_transaksi' => date('Y-m-d H:i:s'),
						'tgl_masuk_uang' => date('Y-m-d H:i:s'),
						'tgl_diambil' => date('Y-m-d H:i:s'),
						'total_harga' => $diskon,
						'dp' => $request->dp,
						'bayar' => $request->dp,
						'jenis_pembayaran' => $request->jenis_pembayaran,
						'status' => $request->status,
						'note' => $request->note,
						'status_pesanan' => $request->status_pesanan,
						'estimasi_waktu'=>  $request->estimasi_waktu,
						'diskon' => $request->diskon,
						'jml_transaksi' => $count
                    ];
                }
            }
        }

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
