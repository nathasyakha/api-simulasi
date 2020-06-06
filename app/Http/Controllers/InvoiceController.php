<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoices = Invoice::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'success' => true,
            'message' => $invoices
        ]);
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
        $invoice = Invoice::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
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
        $invoice = Invoice::findOrFail($id);

        $invoice->user_id = $request->user_id;
        $invoice->treatment_id = $request->treatment_id;
        $invoice->waktu_masuk = $request->waktu_masuk;
        $invoice->total = $request->total;
        $invoice->status = $request->status;

        $invoice->save();

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
