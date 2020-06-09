<?php

namespace App\Http\Controllers\API\Transaksi;

use App\Http\Controllers\Controller;
use App\Item_Transaksi;
use App\Pelanggan;
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
    public function store(Request $request, Transaksi $transaksi, Item_Transaksi $item_transaksi, Pelanggan $pelanggan)
    {
        $date = Carbon::now();
        $kios = DB::table('kios')->where('id', $request->id_kios)->first();
        $total = $request->total - $request->diskon;

        $token = $request->bearerToken();

        $count = DB::table('transaksi')
                     ->select(DB::raw('count(id) as ids'))
                     ->where('pelanggan', '=', $request->id_pelanggan)
                     ->get();

        if (!$request || !$token)
        {
            return $this->errorResponse('JSON Data Request dan Token tidak boleh kosong', 400);
        }

        $id = ['id' => $request->id];

        $pengerjaan = [
            'pengerjaan_nota_id' => $request->pengerjaan_nota_id,
            'pengerjaan_nota_nama' => $request->pengerjaan_nota_nama,
        ];
        
        $diskon = ['diskon' => $request->diskon];

        /** 
         * Init Request Data
         * 
         * Without = [
         *  'pengerjaan_nota_id',
         *  'pengerjaan_nota_nama',
         *  'diskon']
         * 
         * */ 

        $data = [
            'owner_id' => $kios->id_owner,
            'pelanggan_id' => $request->id_pelanggan,
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
            'jml_transaksi' => $count
        ];

        if (isset($request->id))
        {
            if (isset($request->pengerjaan_nota_id) && isset($request->pengerjaan_nota_nama))
            {
                if (isset($request->diskon))
                {                    
                    Transaksi::create($id, $data, $pengerjaan, $diskon);

                    $pelanggan = Pelanggan::find($request->id_pelanggan);
                    $pelanggan->jml_transaksi = $count + 1;
                    $pelanggan->save();

                    Transaksi::where('pelanggan_id', $request->id_pelanggan)->update(['jml_transaksi' => $count + 1]);

                    $total_harga = $diskon;

                    foreach($request->order as $data_row){
                        $data_input_item = [
                            'transaksi_id' => $id,
                            'harga_layanan_id' =>$data_row->id,
                            'kuantitas' => $data_row->qty,
                            'harga' => $data_row->harga,
                        ];
                        
                        Item_Transaksi::create($data_input_item);
                    }
                }
                else {
                    $trans = Transaksi::create($id, $data, $pengerjaan);
                }
            }
            else {
                if (isset($request->diskon))
                {
                    $trans = Transaksi::create($id, $data, $diskon);
                }
                else {
                    $trans = Transaksi::create($id, $data);
                }
            }    
        }
        else 
        {
            if (isset($request->pengerjaan_nota_id) && isset($request->pengerjaan_nota_nama))
            {
                if (isset($request->diskon))
                {
                    $trans = Transaksi::create($data, $pengerjaan, $diskon);
                }
                else {
                    $trans = Transaksi::create($data, $pengerjaan);
                }
            }
            else {
                if (isset($request->diskon))
                {
                    $trans = Transaksi::create($data, $diskon);
                }
                else {
                    $trans = Transaksi::create($data);
                }
            }    
        }

        $output = [
            'status' => true,
            'pesan' => "sukses melakukan transaksi" ,
            'data' => null,
            'id' => $id,
            'total_harga' => $total_harga
        ];
        
        return response()->json($output, 200);
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
