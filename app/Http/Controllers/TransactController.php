<?php

namespace App\Http\Controllers;

use App\Detail_Transact;
use App\Transact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transacts = DB::table('transacts')
            ->leftJoin('users', 'users.id', '=', 'transacts.user_id')
            ->leftJoin('detail__transacts', 'detail__transacts.transact_id', '=', 'transacts.id')
            ->leftJoin('treatment__prices', 'treatment__prices.id', '=', 'detail__transacts.treatment_price_id')
            ->select(
                'transacts.*',
                'users.username',
                'detail__transacts.transact_id',
                'detail__transacts.treatment_price_id',
                'detail__transacts.treatment_type_id',
                'detail__transacts.qty',
                'detail__transacts.price',
                'detail__transacts.total',
                'treatment__prices.harga'
            )->where('transacts.user_id', '=', Auth::user()->id)->get();


        if (request()->ajax()) {
            return DataTables::of($transacts)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editForm"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transact');
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
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
        ]);

        $transact = Transact::create([
            'user_id' => Auth::user()->id,
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'amount' => 0,
            'status' => $request['status']
        ]);

        $transacts = DB::table('transacts')
            ->leftJoin('users', 'users.id', '=', 'transacts.user_id')
            ->leftJoin('detail__transacts', 'detail__transacts.transact_id', '=', 'transacts.id')
            ->leftJoin('treatment__prices', 'treatment__prices.id', '=', 'detail__transacts.treatment_price_id')
            ->select(
                'transacts.*',
                'users.username',
                'detail__transacts.transact_id',
                'detail__transacts.treatment_price_id',
                'detail__transacts.treatment_type_id',
                'detail__transacts.qty',
                'detail__transacts.total',
                'treatment__prices.harga'
            )->where('transacts.user_id', '=', Auth::user()->id)->get();

        foreach ($transacts as $row) {
            $harga = $row->harga;
        }

        if ($transact) {
            $dettrans = Detail_Transact::create([
                'transact_id' => $transact->id,
                'treatment_price_id' => $request['treatment_price_id'],
                'treatment_type_id' => $request['treatment_type_id'],
                'qty' => $request['qty'],
                'price' => $request['qty'] * $harga,
                'total' => 0
            ]);
        }
        $amount = 0;
        $amount += $dettrans->price;
        $transact->update(['amount' => $amount]);

        return response()->json($dettrans);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transact  $transact
     * @return \Illuminate\Http\Response
     */
    public function show(Transact $transact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transact  $transact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $transact = Transact::find($id);

            return response()->json($transact);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transact  $transact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
        ]);

        $transact = Transact::findOrFail($id);

        $transact['user_id'] = Auth::user()->id;
        $transact['amount'] = $request->amount;
        $transact['start_date'] = $request->start_date;
        $transact['end_date'] = $request->end_date;
        $transact['status'] = $request->status;

        $transact->update();
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
     * @param  \App\Transact  $transact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transact = Transact::findOrFail($id);

        $transact->delete();

        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
