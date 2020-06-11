<?php

namespace App\Http\Controllers;

use App\Treatment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treatment = Treatment::all();
        if (request()->ajax()) {
            return DataTables::of($treatment)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('treatment');
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
            return response()->json($treatment);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $treatment = Treatment::find($id);

            return response()->json([
                'success' => true,
                'data' => $treatment
            ]);
        }
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
        $request->validate([
            'jenis_treatment' => 'required',
            'harga' => 'required',
            'waktu_pengerjaan' => 'required',
            'qty' => 'required',

        ]);

        $treatment = Treatment::find($id);

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
