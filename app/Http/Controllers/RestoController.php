<?php

namespace App\Http\Controllers;

use App\Models\Resto;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class RestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $restos = Resto::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();
        if ($restos) {
            return ApiFormatter::createAPI(200, 'success', $restos);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => 'required',
                'nama' => 'required|max:10',
                'pesanan' => 'required',
                'level' => 'required|numeric',
                'jumlah' => 'required|numeric',
            ]);
            $resto = Resto::create([
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'pesanan' => $request->pesanan,
                'level' => $request->level,
                'jumlah' => $request->jumlah,
            ]);
            $hasilTambahData = Resto::where('id', $resto->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'success', $resto);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch(Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $resto = Resto::find($id);
            if ($resto) {
                return ApiFormatter::createAPI(200, 'success', $resto);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // cek validasi inputan pada body postman
            $request->validate([
                'tanggal' => 'required',
                'nama' => 'required|max:10',
                'pesanan' => 'required',
                'level' => 'required|numeric',
                'jumlah' => 'required|numeric',
            ]);
            $resto = Resto::find($id);
            $resto->update([
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'pesanan' => $request->pesanan,
                'level' => $request->level,
                'jumlah' => $request->jumlah,
            ]);
            $dataTerbaru = Resto::where('id', $resto->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage()); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $resto = Resto::find($id);
            $cekBerhasil = $resto->delete();
            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

        public function trash()
        {
            try{
                $restos = Resto::onlyTrashed()->get();
                if ($restos){ 
                    return ApiFormatter::createAPI(200, 'succes', $restos);
                }else {
                    return ApiFormatter::createAPI(400, 'failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createAPI(400, 'error', $error->getMessage());
            }
        }

    public function restore($id)
    {
        try {
            $resto = Resto::onlyTrashed()->where('id', $id);
            $resto->restore();
            $dataKembali = Resto::where('id', $id)->first();
            if ($dataKembali) {
                return ApiFormatter::createAPI(200, 'succes', $dataKembali);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
                return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $resto = Resto::onlyTrashed()->where('id', $id);
            $proses = $resto->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'succes', 'Berhasil hapus permanen!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

}