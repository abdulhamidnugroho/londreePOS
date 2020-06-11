<?php

namespace App\Http\Controllers\API\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Item_Transaksi;
use App\Pelanggan;
use App\Traits\ApiResponser;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
    public function store(Request $request, Transaksi $transaksi, Item_Transaksi $item_transaksi)
    {
        $data = json_decode($request->data);

        if (!$data){
            return $this->errorResponse('Data Request tidak boleh kosong', 400);
        }

        $id = $request->id;
        $kios = DB::table('kios')->where('id', $data->id_kios)->value('id_owner');
        $diskon = $data->total - $data->diskon;
        $count = Transaksi::where('pelanggan_id',$data->id_pelanggan)->count();
        $finalCount = $count + 1;

        try {
            if (isset($request->id))
            {
                if (isset($data->pengerjaan_nota_id) && isset($data->pengerjaan_nota_nama))
                {
                    if (isset($data->diskon))
                    {   
                        Transaksi::create([
                            'id' => $request->id,
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => $data->pengerjaan_nota_id,
                            'pengerjaan_nota_nama' => $data->pengerjaan_nota_nama,
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $diskon,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => $data->diskon,
                            'jml_transaksi' => $finalCount							 
                        ]);

                        $idPelanggan = $data->id_pelanggan;

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $diskon;

                        foreach($data->order as $data_row){
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
                        Transaksi::create([
                            'id' => $request->id,
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => $data->pengerjaan_nota_id,
                            'pengerjaan_nota_nama' => $data->pengerjaan_nota_nama,
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $data->total,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => '',
                            'jml_transaksi' => $finalCount							 
                        ]);

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);
                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $data->total;
                        foreach($data->order as $data_row){
                            $data_input_item = [
                                'transaksi_id' => $id,
                                'harga_layanan_id' =>$data_row->id,
                                'kuantitas' => $data_row->qty,
                                'harga' => $data_row->harga,
                            ];
                            Item_Transaksi::create($data_input_item);
                        }
                    }
                }
                else {
                    if (isset($data->diskon))
                    {
                        Transaksi::create([
                            'id' => $request->id,
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => 0,
                            'pengerjaan_nota_nama' => '-',
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $diskon,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => $data->diskon,
                            'jml_transaksi' => $finalCount							 
                        ]);

                        $idPelanggan = $data->id_pelanggan;

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $diskon;

                        foreach($data->order as $data_row){
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
                        Transaksi::create([
                            'id' => $request->id,
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => 0,
                            'pengerjaan_nota_nama' => '-',
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $data->total,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => '',
                            'jml_transaksi' => $finalCount							 
                        ]);

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $data->total;

                        foreach($data->order as $data_row){
                            $data_input_item = [
                                'transaksi_id' => $id,
                                'harga_layanan_id' =>$data_row->id,
                                'kuantitas' => $data_row->qty,
                                'harga' => $data_row->harga,
                            ];
                            
                            Item_Transaksi::create($data_input_item);
                        }
                    }
                }    
            }
            else 
            {
                if (isset($data->pengerjaan_nota_id) && isset($data->pengerjaan_nota_nama))
                {
                    if (isset($data->diskon))
                    {
                        Transaksi::create([
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => $data->pengerjaan_nota_id,
                            'pengerjaan_nota_nama' => $data->pengerjaan_nota_nama,
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $diskon,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => $data->diskon,
                            'jml_transaksi' => $finalCount							 
                        ]);

                        $idPelanggan = $data->id_pelanggan;

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $diskon;

                        foreach($data->order as $data_row){
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
                        Transaksi::create([
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => $data->pengerjaan_nota_id,
                            'pengerjaan_nota_nama' => $data->pengerjaan_nota_nama,
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $data->total,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => '',
                            'jml_transaksi' => $finalCount							 
                        ]);

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);
                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $data->total;
                        foreach($data->order as $data_row){
                            $data_input_item = [
                                'transaksi_id' => $id,
                                'harga_layanan_id' =>$data_row->id,
                                'kuantitas' => $data_row->qty,
                                'harga' => $data_row->harga,
                            ];
                            Item_Transaksi::create($data_input_item);
                        }
                    }
                }
                else {
                    if (isset($data->diskon))
                    {
                        Transaksi::create([
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => 0,
                            'pengerjaan_nota_nama' => '-',
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $diskon,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => $data->diskon,
                            'jml_transaksi' => $finalCount							 
                        ]);

                        $idPelanggan = $data->id_pelanggan;

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $diskon;

                        foreach($data->order as $data_row){
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
                        Transaksi::create([
                            'owner_id' => $data->owner_id,							 
                            'kios_id' => $data->id_kios,
                            'pelanggan_id' => $data->id_pelanggan,
                            'pengerjaan_nota_id' => 0,
                            'pengerjaan_nota_nama' => '-',
                            'status_order' => $data->status_order,
                            'tgl_transaksi' => date('Y-m-d H:i:s'),
                            'tgl_masuk_uang' => date('Y-m-d H:i:s'),
                            'tgl_diambil' => date('Y-m-d H:i:s'),
                            'total_harga' => $data->total,
                            'dp' => $data->dp,
                            'bayar' => $data->dp,
                            'jenis_pembayaran' => $data->jenis_pembayaran,
                            'status' => $data->status,
                            'note' => $data->note,
                            'status_pesanan' => $data->status_pesanan,
                            'estimasi_waktu'=>  $data->estimasi_waktu,
                            'diskon' => '',
                            'jml_transaksi' => $finalCount							 
                        ]);

                        Transaksi::where('pelanggan_id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        Pelanggan::where('id', $data->id_pelanggan)->update(['jml_transaksi' => $finalCount]);

                        $total_harga = $data->total;

                        foreach($data->order as $data_row){
                            $data_input_item = [
                                'transaksi_id' => $id,
                                'harga_layanan_id' =>$data_row->id,
                                'kuantitas' => $data_row->qty,
                                'harga' => $data_row->harga,
                            ];
                            
                            Item_Transaksi::create($data_input_item);
                        }
                    }
                }    
            }

            $output = [
                'status' => true,
                'pesan' => "Sukses melakukan transaksi" ,
                'data' => null,
                'id' => $id,
                'total_harga' => $total_harga
            ];
        
            return response()->json($output, 200);

        } catch(\Exeception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Error, Gagal melakukan transaksi. - {$exception->getMessage()}"
            ], 500);
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
