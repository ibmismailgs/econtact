<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Thana;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;



class ThanaController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('thanas')
                    ->leftJoin('districts','districts.id','=','thanas.district_id')
                    ->leftJoin('divisions','divisions.id','=','districts.division_id')
                    ->select('thanas.name as thanaName','thanas.id','divisions.name as divisionName','thanas.status as thanaStatus', 'districts.name as districtName')
                    ->whereNull('thanas.deleted_at')
                    ->orderByDesc('thanas.id')
                    ->get();

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                    if (Auth::user()->can('thana_status')) {
                        $button = '<label class="switch">';
                        $button .= ' <input type="checkbox" class="changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->thanaStatus == 1) {
                            $button .= "checked";
                        }
                        $button .= ' ><span class="slider round"></span>';
                        $button .= '</label>';
                        return $button;
                    }else{
                            if($data->thanaStatus == 1){
                                return '<span class="badge badge-success" title="Active">Active</span>';
                            }elseif($data->thanaStatus == 0){
                                return '<span class="badge badge-danger" title="Inactive">Inactive</span>';
                            }
                        }

                    })

                    ->addColumn('action', function ($data) {
                        $button = '';

                        $edit = '<a class="menu-item mr-5 edit" id="edit" href="' . route('thana.edit', $data->id) . ' " title="Edit" data-toggle="modal" data-target="#editData"><i class="ik ik-edit f-16 text-green"></i></a>';

                        $delete = '<a class="menu-item" id="delete" href="' . route('thana.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i></a>';


                        if(Auth::user()->can('thana_edit')){
                            $button =  $edit;
                        }
                        if(Auth::user()->can('thana_delete')){
                            $button = $delete;
                        }

                        if((Auth::user()->can('thana_edit')) && (Auth::user()->can('thana_delete'))){
                            $button =  $edit . $delete;
                        }

                        return $button;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status','action'])
                    ->toJson();
            }
            $divisions = Division::where('status', 1)->get();
            $districts = District::where('status', 1)->get();
            return view('settings.thana', compact('divisions','districts'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = Validator::make($request->all(), [
                'name' => 'required|string|unique:thanas,name,NULL,id,deleted_at,NULL',
                'district_id' => 'required|',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $data->errors()->all(),
                ]);
            }

            try {
                $data = new Thana();
                $data->name = $request->name;
                $data->district_id = $request->district_id;
                $data->status = 1;
                $data->created_by = Auth::user()->id;
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Thana created successfully',
                ]);

            } catch (\Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id)
    {
        $data = DB::table('thanas')
            ->leftJoin('districts','districts.id','=','thanas.district_id')
            ->leftJoin('divisions','divisions.id','=','districts.division_id')
            ->select('thanas.name as thanaName','thanas.id as ThanaId','divisions.id as divisionId', 'districts.id as districtId')
            ->whereNull('thanas.deleted_at')
            ->whereNull('divisions.deleted_at')
            ->whereNull('districts.deleted_at')
            ->where('thanas.id', $id)
            ->first();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:thanas,name,' . $id . ',id,deleted_at,NULL',
            'district_id' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()->all(),
            ]);
        }

        try {
            $data = Thana::findOrFail($id);
            $data->name = $request->name;
            $data->district_id = $request->district_id;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return response()->json([
                'success' => true,
                'message' => 'Thana updated successfully',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Thana::findOrFail($id);
            $data->deleted_by = Auth::user()->id;
            $data->update();
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Thana deleted successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Thana deleted failed',
            ]);
        }
    }
    public function StatusChange(Request $request)
    {
        $data = Thana::findOrFail($request->id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->update();

        if ($data->status == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Status activated successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Status inactivated successfully',
            ]);
        }
    }

    public function DivisionWiseDistrict(Request $request){
        try{
            $districts = District::with('divisions')->where('division_id', $request->division_id)->where('status', 1)->get();
            return response()->json([
                'districts' => $districts,
                'message' =>'Data feteched successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' =>'Data feteched failed',
            ]);
        }
    }

    public function DistrictWiseThana(Request $request){
        try{
            $thans = Thana::with('districts')->where('district_id', $request->district_id)->where('status', 1)->get();

            return response()->json([
                'thans' => $thans,
                'message' =>'Data feteched successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' =>'Data feteched failed',
            ]);
        }
    }
}

