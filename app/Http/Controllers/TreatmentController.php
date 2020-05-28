<?php

namespace App\Http\Controllers;

use App\Http\Resources\TreatmentCollection;
use App\Invoice;
use App\Treatment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Treatment::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_treatment' => 'required',
            'harga' => 'required',
            'waktu_pengerjaan' => 'required',
            'qty' => 'required',
        ]);

        $treatment['jenis_treatment'] = $request->jenis_treatment;
        $treatment['harga'] = $request->harga;
        $treatment['waktu_pengerjaan'] = $request->waktu_pengerjaan;
        $treatment['qty'] = $request->qty;
        $treatment['subtotal'] = $request->harga * $request->qty;

        $treat = Treatment::create($treatment);
        $treat->save();
        if ($treat) {
            return response(['data' => new Treatment($treatment)], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $treatment = Treatment::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $treatment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $treatment = Treatment::findOrFail($id);

        $treatment['jenis_treatment'] = $request->jenis_treatment;
        $treatment['harga'] = $request->harga;
        $treatment['waktu_pengerjaan'] = $request->waktu_pengerjaan;
        $treatment['qty'] = $request->qty;
        $treatment['subtotal'] = $request->harga * $request->qty;

        $treatment->save();
        return response()->json(
            [
                'success' => true,
                'message' => 'Updated Successfully'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treatment = Treatment::findOrFail($id);

        $treatment->delete();

        return response()->json(['success' => true, 'message' => 'Treatment Deleted']);
    }
}
