<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\ClientSource;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ClientSourceController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('client_sources')
                    ->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                    if (Auth::user()->can('customer_source_status')) {
                        $button = '<label class="switch">';
                        $button .= ' <input type="checkbox" class="changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" title="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= ' ><span class="slider round"></span>';
                        $button .= '</label>';
                        return $button;
                    }else{
                            if($data->status == 1){
                                return '<span class="badge badge-success" title="Active">Active</span>';
                            }elseif($data->status == 0){
                                return '<span class="badge badge-danger" title="Inactive">Inactive</span>';
                            }
                        }

                    })

                    ->addColumn('action', function ($data) {
                        $button = '';

                        $edit = '<a class="menu-item mr-5 edit" id="edit" href="' . route('client-source.edit', $data->id) . ' " title="Edit" data-toggle="modal" data-target="#editData"><i class="ik ik-edit f-16 text-green"></i></a>';

                        $delete = '<a class="menu-item" id="delete" href="' . route('client-source.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i></a>';


                        if(Auth::user()->can('customer_source_edit')){
                            $button =  $edit;
                        }
                        if(Auth::user()->can('customer_source_delete')){
                            $button = $delete;
                        }

                        if((Auth::user()->can('customer_source_edit')) && (Auth::user()->can('customer_source_delete'))){
                            $button =  $edit . $delete;
                        }

                        return $button;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status','action'])
                    ->toJson();
            }
            return view('settings.client_source');
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
                'title' => 'required|string|unique:client_sources,title,NULL,id,deleted_at,NULL',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $data->errors()->all(),
                ]);
            }

            try {
                $data = new ClientSource();
                $data->title = $request->title;
                $data->status = 1;
                $data->created_by = Auth::user()->id;
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Data created successfully',
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
        $data = ClientSource::findOrFail($id);
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
            'title' => 'required|string|unique:client_sources,title,' . $id . ',id,deleted_at,NULL',
        ]);

        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()->all(),
            ]);
        }

        try {
            $data = ClientSource::findOrFail($id);
            $data->title = $request->title;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully',
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
            $data = ClientSource::findOrFail($id);
            $data->deleted_by = Auth::user()->id;
            $data->update();
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data deleted failed',
            ]);
        }
    }
    public function StatusChange(Request $request)
    {
        $data = ClientSource::findOrFail($request->id);
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
}
