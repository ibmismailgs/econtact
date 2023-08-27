<?php

namespace App\Http\Controllers\Customers;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Settings\Thana;
use App\Models\Settings\Outlet;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Settings\CustomerCategory;
use App\Models\WhatsappMarketing;
use Carbon\Carbon;

class WhatsappController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('whatsapp_marketings')
                    ->select('id','customer_id','text','status','type')
                    ->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {

                    if (Auth::user()->can('manage_user')) {
                        $button = '<label class="switch">';
                        $button .= ' <input type="checkbox" class="changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

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

                    ->addColumn('type', function ($data) {

                        if($data->type == 1){
                            return '<span class="badge badge-primary" title="Individual">Individual</span>';
                        }elseif($data->type == 2){
                            return '<span class="badge badge-primary" title="Group">Group</span>';
                        }
                    })

                    ->addColumn('text', function ($data) {
                        $text = isset($data->text) ? strip_tags($data->text) : '--' ;
                        return Str::limit( $text, 100) ;
                    })

                    ->addColumn('action', function ($data) {

                        $button = '';

                        $show = '<li><a class="dropdown-item" href="' . route('whatsapp-marketing.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('whatsapp-marketing.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('whatsapp-marketing.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';


                        if(Auth::user()->can('manage_user')){
                            $button =  $show . $edit . $delete;
                        }

                        return '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$button.'
                        </ul>
                        </div>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['text','type','status','action'])
                    ->toJson();
            }

            return view('whatsapp.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::where('status', 1)->get();
        $categories = CustomerCategory::where('status', 1)->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        $clients = Customer::where('status', 1)->get();
        return view('whatsapp.create', compact('divisions','categories','clientSources','clientTypes','outlets','clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'type.required' => 'Select message type',
            'text.required' => 'Write message details',
        );

        $this->validate($request, array(
            'type' => 'required',
            'text' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new WhatsappMarketing();
            $data->customer_id           = $request->customer_id;
            $data->type                  = $request->type;
            $data->division_id           = $request->division_id;
            $data->district_id           = $request->district_id;
            $data->thana_id              = $request->thana_id;
            $data->customer_source_id    = $request->customer_source_id;
            $data->customer_category_id  = $request->customer_category_id;
            $data->customer_type_id      = $request->customer_type_id;
            $data->outlet_id             = $request->outlet_id;
            $data->text                  = $request->text;
            $data->status                = 1;
            $data->created_by            = Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect()->route('whatsapp-marketing.index')
                ->with('success', 'Message created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = WhatsappMarketing::with('divisions','districits','thanas','clientSources','customerCategories','customerTypes','outlets','customers')->findOrFail($id);
        $clients = Customer::orWhere('division_id', $data->division_id)
                ->orWhere('district_id', $data->district_id)
                ->orWhere('thana_id', $data->thana_id)
                ->orWhere('client_source_id', $data->customer_source_id)
                ->orWhere('customer_category_id', $data->customer_category_id)
                ->orWhere('customer_type_id', $data->customer_type_id)
                ->orWhere('outlet_id', $data->outlet_id)
                ->get();
        return view('whatsapp.show', compact('data','clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = WhatsappMarketing::findOrFail($id);
        $divisions = Division::where('status', 1)->get();
        $districts = District::where('status', 1)->get();
        $thanas = Thana::where('status', 1)->get();
        $categories = CustomerCategory::where('status', 1)->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        $clients = Customer::where('status', 1)->get();
        return view('whatsapp.edit', compact('divisions','categories','clientSources','clientTypes','outlets','clients','data','districts','thanas'));
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
        $messages = array(
            'type.required' => 'Select message type',
            'text.required' => 'Write message details',
        );

        $this->validate($request, array(
            'type' => 'required',
            'text' => 'required',
        ), $messages);

        try {
            $data = WhatsappMarketing::findOrFail($id);
            $data->customer_id           = $request->customer_id;
            $data->type                  = $request->type;
            $data->division_id           = $request->division_id;
            $data->district_id           = $request->district_id;
            $data->thana_id              = $request->thana_id;
            $data->customer_source_id    = $request->customer_source_id;
            $data->customer_category_id  = $request->customer_category_id;
            $data->customer_type_id      = $request->customer_type_id;
            $data->outlet_id             = $request->outlet_id;
            $data->text                  = $request->text;
            $data->updated_by            = Auth::user()->id;
            $data->update();

            return redirect()->route('whatsapp-marketing.index')
                ->with('success', 'Message updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
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
            $data = WhatsappMarketing::findOrFail($id);
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
        $data = WhatsappMarketing::findOrFail($request->id);
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
