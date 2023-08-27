<?php

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CallManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\CallType;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CallManagementController extends Controller
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

            $auth = Auth::user();

            if ($auth && $auth->roles->count() > 0) {
                $user_role = $auth->roles->first();

                if ($user_role->name == 'Super Admin') {
                    $data = DB::table('call_management')
                    ->leftJoin('customers','customers.id','=','call_management.customer_id')
                    ->leftJoin('call_types','call_types.id','=','call_management.call_type_id')
                    ->select('customers.name','customers.primary_phone','customers.company_name','call_management.id','call_types.title','call_management.date','call_management.time','call_management.note')
                    ->whereNull('call_management.deleted_at')
                    ->orderByDesc('id')
                    ->get();
                }

                if ($user_role->name == 'Supervisor') {

                    $data = DB::table('call_management')
                        ->leftJoin('users','users.id','=','call_management.created_by')
                        ->leftJoin('customers','customers.id','=','call_management.customer_id')
                        ->leftJoin('call_types','call_types.id','=','call_management.call_type_id')
                        ->select('customers.name','customers.primary_phone','customers.company_name','call_management.id','call_types.title','call_management.date','call_management.time','call_management.note','users.user_id')
                        ->where('call_management.created_by', $auth->id)
                        ->orWhere('users.user_id', $auth->id)
                        ->whereNull('call_management.deleted_at')
                        ->orderByDesc('id')
                        ->get();
                }

            }else{
                    $data = DB::table('call_management')
                    ->leftJoin('customers','customers.id','=','call_management.customer_id')
                    ->leftJoin('call_types','call_types.id','=','call_management.call_type_id')
                    ->select('customers.name','customers.primary_phone','customers.company_name','call_management.created_by','call_management.id','call_types.title','call_management.date','call_management.time','call_management.note')
                    ->where('call_management.created_by', Auth::user()->id)
                    ->whereNull('call_management.deleted_at')
                    ->orderByDesc('id')
                    ->get();
                }

                return Datatables::of($data)

                    ->addColumn('note', function ($data) {
                        $note = Str::limit($data->note, 100) ?? '-';
                        return $note;
                    })

                    ->addColumn('followUpDate', function ($data) {
                        $newDate = date('d F, Y', strtotime($data->date . " +30 days"));
                        return $newDate;
                    })

                    ->addColumn('callType', function ($data) {
                        $title = $data->title;
                        return $title;
                    })

                    ->addColumn('company', function ($data) {
                        $company = $data->company_name;
                        return $company;
                    })

                    ->addColumn('dateTime', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        $time = date('g:i a', strtotime($data->time));
                        return $date . ' | ' . $time;
                    })

                    ->addColumn('action', function ($data) {

                        $button = '';

                        $show = '<li><a class="dropdown-item" href="' . route('call-management.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('call-management.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('call-management.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';

                        if(Auth::user()->can('call_show')){
                            $button = $show;
                        }

                        if(Auth::user()->can('call_edit')){
                            $button =  $edit;
                        }

                        if(Auth::user()->can('call_delete')){
                            $button = $delete;
                        }

                        if((Auth::user()->can('call_edit')) && (Auth::user()->can('call_show'))){
                            $button = $show. $edit;
                        }

                        if((Auth::user()->can('call_edit')) && (Auth::user()->can('call_delete'))){
                            $button = $edit . $delete;
                        }

                        if((Auth::user()->can('call_show')) && (Auth::user()->can('call_delete'))){
                            $button = $show . $delete;
                        }

                        if((Auth::user()->can('call_edit')) && (Auth::user()->can('call_delete')) && (Auth::user()->can('call_show'))){
                            $button = $show. $edit . $delete;
                        }

                        return '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$button.'
                        </ul>
                        </div>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['note','action','dateTime','callType','company','followUpDate'])
                    ->toJson();
            }

            return view('callmanagement.index');
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
        $clients = Customer::where('status', 1)->get();
        $callTypes = CallType::where('status', 1)->get();
        return view('callmanagement.create', compact('callTypes','clients'));
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
            'call_type_id.required' => 'Select Call Type',
            'customer_id.required' => 'Select Customer',
            'date.required' => 'Enter date',
            'time.required' => 'Enter time',
        );

        $this->validate($request, array(
            'call_type_id' => 'required',
            'customer_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ), $messages);

        try {
            $existCall = CallManagement::where('customer_id', $request->customer_id)->first();
            $data = new CallManagement();
            $data->customer_id      = $request->customer_id;
            $data->call_type_id     = $request->call_type_id;
            $data->date             = $request->date;
            $data->time             = $request->time;

            if($existCall){
                $data->re_call      = 1;
                $existCall->re_call = 1;
                $existCall->update();
            }else{
                $data->re_call      = 0;
            }

            $data->note             = $request->note;
            $data->created_by       = Auth::user()->id;
            $data->save();

            $customer = Customer::where('id', $data->customer_id)->first();
            $customer->is_call = 1;
            $customer->update();

            return redirect()->route('call-management.index')
                ->with('success', 'Data created successfully');
        } catch (\Exception $exception) {
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
        $data = CallManagement::with('customers','callTypes')->findOrFail($id);
        return view('callmanagement.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CallManagement::findOrFail($id);
        $clients = Customer::where('status', 1)->get();
        $callTypes = CallType::where('status', 1)->get();
        return view('callmanagement.edit', compact('clients','callTypes','data'));
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
            'call_type_id.required' => 'Select Call Type',
            'customer_id.required' => 'Select Customer',
            'date.required' => 'Enter date',
            'time.required' => 'Enter time',
        );

        $this->validate($request, array(
            'call_type_id' => 'required',
            'customer_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ), $messages);

        try {
            $data = CallManagement::findOrFail($id);
            $data->customer_id      = $request->customer_id;
            $data->call_type_id     = $request->call_type_id;
            $data->date             = $request->date;
            $data->time             = $request->time;
            $data->note             = $request->note;
            $data->updated_by       = Auth::user()->id;
            $data->update();

            return redirect()->route('call-management.index')
                ->with('success', 'Data created successfully');
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
            $data = CallManagement::findOrFail($id);
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
}
