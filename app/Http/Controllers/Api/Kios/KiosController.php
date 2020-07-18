<?php

namespace App\Http\Controllers\Api\Kios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\ApiResponser;

class KiosController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listkios()
    {
        $dataAdmin = DB::table('admin')->where('id', JWTAuth::user()->id)->first();
        $admin_id = ($dataAdmin->id_owner) ? $dataAdmin->id_owner : JWTAuth::user()->id;

        $data = DB::table('kios')->select('id', 'nama', 'alamat', 'no_telp', 'latitude', 'pesan_antar', 'ketentuan', 'estimasi', 'pesan_wa_sms')
            ->where('id_owner', $admin_id)
            ->where('trash', 0)
            ->get();
        
        return $this->showAll($data, 200);
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
