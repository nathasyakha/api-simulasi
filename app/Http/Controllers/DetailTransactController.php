<?php

namespace App\Http\Controllers;

use App\Detail_Transact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DetailTransactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dettrans = DB::table('detail__transacts')
            ->leftJoin('transacts', 'transacts.id', '=', 'detail__transacts.transact_id')
            ->leftJoin('treatment__prices', 'treatment__prices.id', '=', 'detail__transacts.treatment_price_id')
            ->leftJoin('treatment_types', 'treatment_types.id', '=', 'detail__transacts.treatment_type_id')
            ->select(
                'detail__transacts.*',
                'treatment__prices.harga',
                'treatment_types.nama'
            )->get();

        if (request()->ajax()) {
            return DataTables::of($dettrans)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editForm"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('detail_transact');
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
            'transact_id' => 'required',
            'treatment_price_id' => 'required',
            'treatment_type_id' => 'required',
            'qty' => 'required',
        ]);

        $dettransact = DB::table('detail__transacts')
            ->leftJoin('transacts', 'transacts.id', '=', 'detail__transacts.transact_id')
            ->leftJoin('treatment__prices', 'treatment__prices.id', '=', 'detail__transacts.treatment_price_id')
            ->leftJoin('treatment_types', 'treatment_types.id', '=', 'detail__transacts.treatment_type_id')
            ->select(
                'detail__transacts.*',
                'treatment__prices.harga',
                'treatment_types.nama'
            )->get();

        foreach ($dettransact as $dtran) {
            $total = $dtran->harga;
        }

        $dettrans['transact_id'] = $request->transact_id;
        $dettrans['treatment_price_id'] = $request->treatment_price_id;
        $dettrans['treatment_type_id'] = $request->treatment_type_id;
        $dettrans['qty'] = $request->qty;
        $dettrans['price'] = $total * $request->qty;
        $dettrans['total'] = 0;

        $dt = Detail_Transact::create($dettrans);
        $dt->save();
        if ($dt) {
            return response()->json($dettrans);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Detail_Transact  $detail_Transact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail_Transact  $detail_Transact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $dettrans = Detail_Transact::find($id);

            return response()->json($dettrans);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail_Transact  $detail_Transact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'transact_id' => 'required',
            'treatment_price_id' => 'required',
            'treatment_type_id' => 'required',
            'qty' => 'required',
        ]);

        $dettrans = Detail_Transact::findOrFail($id);

        $dettransact = DB::table('detail__transacts')
            ->leftJoin('transacts', 'transacts.id', '=', 'detail__transacts.transact_id')
            ->leftJoin('treatment__prices', 'treatment__prices.id', '=', 'detail__transacts.treatment_price_id')
            ->leftJoin('treatment_types', 'treatment_types.id', '=', 'detail__transacts.treatment_type_id')
            ->select(
                'detail__transacts.*',
                'treatment__prices.harga',
                'treatment_types.nama'
            )->get();

        foreach ($dettransact as $dtran) {
            $total = $dtran->harga;
        }

        $dettrans['transact_id'] = $request->transact_id;
        $dettrans['treatment_price_id'] = $request->treatment_price_id;
        $dettrans['treatment_type_id'] = $request->treatment_type_id;
        $dettrans['qty'] = $request->qty;
        $dettrans['price'] = $total * $request->qty;
        $dettrans['total'] = 0;


        $dettrans->update();
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
     * @param  \App\Detail_Transact  $detail_Transact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dettrans = Detail_Transact::findOrFail($id);

        $dettrans->delete();

        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
