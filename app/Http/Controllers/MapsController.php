<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MapsController extends Controller
{
    //
    public function home()
    {
        return view('welcome');
    }

    public function getLoc()
    {
        return Location::all();
    }

    public function store(Request $request)
    {
        if ($request->id) {
            $location = Location::find($request->id);

            $location->alamat = $request->alamat;
            $location->detailAlamat = $request->detailAlamat;
            $location->kota = $request->kota;
            $location->provinsi = $request->provinsi;
            $location->kodePos = $request->kodePos;
            $location->lat = $request->lat;
            $location->lng = $request->lng;

            if ($location->save()) {
                return response()->json(["message" => "Berhasil Ubah Alamat !"], 200);
            } else {
                return response()->json(["message" => "Terjadi kesalahan diserver !"], 500);
            }
        } else {
            $validate = Validator::make($request->all(), [
                "namaAlamat" => "required",
                "alamat" => "required",
                "detailAlamat" => "required",
                "kota" => "required",
                "provinsi" => "required",
                "kodePos" => "required",
            ]);
            if ($validate->fails()) {
                return response()->json(["message" => $validate->errors()], 500);
            }
            $location = new Location;

            if ($location->create($request->all())) {
                return response()->json(["message" => "Berhasil Tambah Alamat !"], 200);
            } else {
                return response()->json(["message" => "Terjadi kesalahan diserver !"], 500);
            }
        }
    }
}
