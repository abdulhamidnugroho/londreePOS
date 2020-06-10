<?php

namespace App\Http\Controllers\API\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Item_Transaksi;
use App\Pelanggan;
use App\Traits\ApiResponser;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class TransaksiController extends Controller
{
    use TraitsApiResponser;

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
     * @param  \Illuminate\Http\Request  $data
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaksi $transaksi, Item_Transaksi $item_transaksi, Pelanggan $pelanggan)
    {
        $data = json_decode($request->data);

        $kios = DB::table('kios')->where('id', $data->id_kios)->value('id_owner');
        $total = $data->total - $data->diskon;

        $count = DB::table('transaksi')
                     ->select(DB::raw('count(id) as ids'))
                     ->where('pelanggan_id', '=', $data->id_pelanggan)
                     ->get();

        if (!$data)
        {
            return $this->errorResponse('JSON Data Request dan Token tidak boleh kosong', 400);
        }

        // $id = ['id' => $data->id];

        $pengerjaan = [
            'pengerjaan_nota_id' => $data->pengerjaan_nota_id,
            'pengerjaan_nota_nama' => $data->pengerjaan_nota_nama,
        ];

        /** 
         * Init Request Data
         * Without = [ 'pengerjaan_nota_id', 'pengerjaan_nota_nama', 'diskon']
         *  
         * */ 
        
        $dataInit = [
            'owner_id' => $data->owner_id,
            'pelanggan_id' => $data->id_pelanggan,
            'status_order' => $data->status_order,
            'tgl_transaksi' => date('Y-m-d H:i:s'),
            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
            'tgl_diambil' => date('Y-m-d H:i:s'),
            'total_harga' => 4124,
            'dp' => $data->dp,
            'bayar' => $data->dp,
            'jenis_pembayaran' => $data->jenis_pembayaran,
            'status' => $data->status,
            'note' => $data->note,
            'status_pesanan' => $data->status_pesanan,
            'estimasi_waktu'=>  $data->estimasi_waktu,
            'jml_transaksi' => $count
        ];

        // dd($dataInput);
        

        try {
            $trans = Transaksi::create([
                'owner_id' => 4324234,
                'pelanggan_id' => 4234234,
                'kios_id' => 1209,
                'pengerjaan_nota_id' => 20391,
                'pengerjaan_nota_nama' => 'dsadasd',
                'tgl_transaksi' => date('Y-m-d H:i:s'),
                'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                'tgl_diambil' => date('Y-m-d H:i:s'),
                'total_harga' => $data->diskon,
                'dp' => $data->dp,
                'bayar' => $data->dp,
                'jenis_pembayaran' => $data->jenis_pembayaran,
                'status' => $data->status,
                'status_kerja' => 0,
                'note' => $data->note,
                'status_pesanan' => $data->status_pesanan,
                'estimasi_waktu'=>  $data->estimasi_waktu,
                'jml_transaksi' => 1,
                'status_order' => 0,
                'diskon' => 0,
                'trash' => 0,
            ]);

            return $this->showOne($trans, 200);;

        } catch(\Exeception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Error: Book not created!, please try again. - {$exception->getMessage()}"
            ], 500);
        }

        // if (isset($data->id))
        // {
        //     if (isset($data->pengerjaan_nota_id) && isset($data->pengerjaan_nota_nama))
        //     {
        //         if (isset($data->diskon))
        //         {                    
        //             Transaksi::create($id, $data, $pengerjaan, $diskon);

        //             $pelanggan = Pelanggan::find($data->id_pelanggan);
        //             $pelanggan->jml_transaksi = $count + 1;
        //             $pelanggan->save();

        //             Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $count + 1]);

        //             $total_harga = $diskon;

        //             foreach($data->order as $data_row){
        //                 $data_input_item = [
        //                     'transaksi_id' => $id,
        //                     'harga_layanan_id' =>$data_row->id,
        //                     'kuantitas' => $data_row->qty,
        //                     'harga' => $data_row->harga,
        //                 ];
                        
        //                 Item_Transaksi::create($data_input_item);
        //             }
        //         }
        //         else {
        //             $trans = Transaksi::create($id, $data, $pengerjaan);
        //         }
        //     }
        //     else {
        //         if (isset($data->diskon))
        //         {
        //             $trans = Transaksi::create($id, $data, $diskon);
        //         }
        //         else {
        //             $trans = Transaksi::create($id, $data);
        //         }
        //     }    
        // }
        // else 
        // {
        //     if (isset($data->pengerjaan_nota_id) && isset($data->pengerjaan_nota_nama))
        //     {
        //         if (isset($data->diskon))
        //         {
        //             $trans = Transaksi::create($data, $pengerjaan, $diskon);
        //         }
        //         else {
        //             $trans = Transaksi::create($data, $pengerjaan);
        //         }
        //     }
        //     else {
        //         if (isset($data->diskon))
        //         {
        //             $trans = Transaksi::create($data, $diskon);
        //         }
        //         else {
        //             $trans = Transaksi::create($data);
        //         }
        //     }    
        // }

        // $output = [
        //     'status' => true,
        //     'pesan' => "sukses melakukan transaksi" ,
        //     'data' => null,
        //     'id' => $id,
        //     'total_harga' => $total_harga
        // ];
        
        // return response()->json($output, 200);
        
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
     * @param  \Illuminate\Http\Request  $data
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data, $id)
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
