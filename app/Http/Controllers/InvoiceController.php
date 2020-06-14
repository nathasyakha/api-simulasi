<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Treatment;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = auth()->user()->invoices()
            ->leftJoin('treatments', 'invoices.treatment_id', '=', 'treatments.id')
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->select('invoices.*', 'treatments.jenis_treatment', 'users.username')
            ->get();
        $treatments = Treatment::all();
        $users = User::all();

        if (request()->ajax()) {
            return DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('invoice', compact('treatments', 'users'));
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

            'treatment_id' => 'required',
            'waktu_masuk' => 'required',
            'status' => 'required'
        ]);

        $invoices = auth()->user()->invoices()
            ->leftJoin('treatments', 'invoices.treatment_id', '=', 'treatments.id')
            ->select('invoices.*', 'treatments.subtotal')
            ->get();

        $res = 0;
        foreach ($invoices as $invs) {
            $res += $invs->subtotal;
        }


        $invoice['user_id'] = auth()->user()->id;
        $invoice['treatment_id'] = $request->treatment_id;
        $invoice['waktu_masuk'] = $request->waktu_masuk;
        $invoice['total'] = $res;
        $invoice['status'] = $request->status;
        $inv = Invoice::create($invoice);
        $inv->save();


        if ($inv) {
            return response(['data' => new Invoice($invoice)], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'treatment_id' => 'required',
            'waktu_masuk' => 'required',
            'status' => 'required'
        ]);
        $invoice = Invoice::findOrFail($id);

        $invoices = auth()->user()->invoices()
            ->leftJoin('treatments', 'invoices.treatment_id', '=', 'treatments.id')
            ->select('invoices.*', 'treatments.subtotal')
            ->get();

        $res = 0;
        foreach ($invoices as $invs) {
            $res += $invs->subtotal;
        }


        $invoice['user_id'] = auth()->user()->id;
        $invoice['treatment_id'] = $request->treatment_id;
        $invoice['waktu_masuk'] = $request->waktu_masuk;
        $invoice['total'] = $res;
        $invoice['status'] = $request->status;
        $invoice->update();

        return response()->json(
            [
                'success' => true,
                'message' => 'Updated Successfully',
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->delete();

        return response()->json(['success' => true, 'message' => 'Invoice Deleted']);
    }
}
