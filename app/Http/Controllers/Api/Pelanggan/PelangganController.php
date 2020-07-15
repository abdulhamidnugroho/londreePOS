<?php

namespace App\Http\Controllers\API\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ApiResponser;

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
    public function store(Request $request)
    {
        //
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
