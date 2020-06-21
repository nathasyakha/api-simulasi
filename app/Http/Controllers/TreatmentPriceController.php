<?php

namespace App\Http\Controllers;

use App\Treatment_Price;
use App\Treatment_type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TreatmentPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treatprice = DB::table('treatment__prices')
            ->leftJoin('users', 'users.id', '=', 'treatment__prices.user_id')
            ->leftJoin('treatment_types', 'treatment_types.id', '=', 'treatment__prices.treatment_type_id')
            ->select('treatment__prices.*', 'users.username', 'treatment_types.nama')
            ->where('user_id', '=', Auth::user()->id)
            ->get();


        //$treatprice = Treatment_Price::all();

        if (request()->ajax()) {
            return DataTables::of($treatprice)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editForm"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('treatment_price');
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
            'treatment_type_id' => 'required',
            'harga' => 'required',
        ]);

        $treatprice['treatment_type_id'] = $request->treatment_type_id;
        $treatprice['harga'] = $request->harga;
        $treatprice['user_id'] = Auth::user()->id;

        $tp = Treatment_Price::create($treatprice);
        $tp->save();
        if ($tp) {
            return response()->json($treatprice);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment_Price  $treatment_Price
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment_Price $treatment_Price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment_Price  $treatment_Price
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $treatment = Treatment_Price::find($id);

            return response()->json($treatment);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment_Price  $treatment_Price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'treatment_type_id' => 'required',
            'harga' => 'required',
        ]);

        $treatprice = Treatment_Price::findOrFail($id);

        $treatprice['treatment_type_id'] = $request->treatment_type_id;
        $treatprice['harga'] = $request->harga;
        $treatprice['user_id'] = Auth::user()->id;

        $treatprice->update();
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
     * @param  \App\Treatment_Price  $treatment_Price
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treatprice = Treatment_Price::findOrFail($id);

        $treatprice->delete();

        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
