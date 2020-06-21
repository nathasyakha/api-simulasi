<?php

namespace App\Http\Controllers;

use App\Treatment_type;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TreatmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treattype = Treatment_type::all();
        if (request()->ajax()) {
            return DataTables::of($treattype)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editForm"><i class="far fa-edit"></i> Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('treatment_type');
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
            'nama' => 'required',
        ]);

        $treattype['nama'] = $request->nama;

        $ttype = Treatment_type::create($treattype);
        $ttype->save();
        if ($ttype) {
            return response()->json($treattype);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment_type  $treatment_type
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment_type $treatment_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment_type  $treatment_type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $treatment = Treatment_type::find($id);

            return response()->json($treatment);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment_type  $treatment_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $treattype = Treatment_type::findOrFail($id);

        $treattype['nama'] = $request->nama;

        $treattype->update();
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
     * @param  \App\Treatment_type  $treatment_type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treattype = Treatment_type::findOrFail($id);

        $treattype->delete();

        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
