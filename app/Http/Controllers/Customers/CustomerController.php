<?php

namespace App\Http\Controllers\Customers;

use App\Models\SMS;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\Settings\Thana;
use App\Models\Settings\Outlet;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Settings\CustomerCategory;

class CustomerController extends Controller
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
                    $data = DB::table('customers')
                        ->select('name','id','email','primary_phone','status','created_by','assign_to','date','is_meeting','company_name')
                        ->whereNull('deleted_at')
                        ->orderByDesc('id')
                        ->get();
                } elseif ($user_role->name == 'Supervisor') {
                    $data = DB::table('customers')
                        ->leftJoin('users','users.id','=','customers.created_by')
                        ->select('customers.name','customers.id','customers.email','customers.primary_phone','customers.status','customers.created_by','customers.assign_to','customers.date','customers.is_meeting','customers.company_name','users.user_id')
                        ->whereNull('customers.deleted_at')
                        ->where('customers.created_by', $auth->id)
                        ->orWhere('users.user_id', $auth->id)
                        ->orderByDesc('customers.id')
                        ->get();
                }
            }else {
                $data = DB::table('customers')
                    ->select('name','id','email','primary_phone','status','created_by','assign_to','date','is_meeting','company_name')
                    ->whereNull('deleted_at')
                    ->where('created_by', $auth->id)
                    ->orderByDesc('id')
                    ->get();
            }

                return Datatables::of($data)

                    ->addColumn('name', function ($data) {

                        $newDate = date('Y-m-d', strtotime($data->date . " +30 days"));
                        $currentDate = now()->format('Y-m-d');

                        if($currentDate > $newDate && $data->is_meeting == 0){
                            $color = 'red';
                            $name = '<span style="color:'.$color.'">'.$data->name.'</span>';
                        }else{
                            $name = '<span>'.$data->name.'</span>';
                        }
                        return $name;
                    })

                    ->addColumn('designation', function ($data) {
                        $designation = $data->designation ?? '-';
                       return $designation;
                    })

                    ->addColumn('company', function ($data) {
                        $company = $data->company_name ?? '-';
                       return $company;
                    })

                    ->addColumn('assign', function ($data) {
                       if($data->assign_to != null){
                        $employee = DB::table('users')->where('id', $data->assign_to)->first();
                       }else{
                        $employee = DB::table('users')->where('id', $data->created_by)->first();
                       }
                       return $employee->name ?? '--';
                    })

                    ->addColumn('status', function ($data) {

                    if (Auth::user()->can('customer_status')) {
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

                    ->addColumn('action', function ($data) {

                        $button = '';

                        $show = '<li><a class="dropdown-item" href="' . route('client.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('client.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('client.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';

                        $assign = '<a class="dropdown-item mr-5 status assign" id="assignId" href="' . route('client.assign', $data->id) . ' " title="Status" data-toggle="modal" data-target="#assignData"><i class="fa fa-stream fa-tasks f-16 text-green"></i> Assign</a>';

                        if(Auth::user()->can('customer_show')){
                            $button = $show;
                        }

                        if(Auth::user()->can('customer_edit')){
                            $button =  $edit;
                        }

                        if(Auth::user()->can('customer_delete')){
                            $button = $delete;
                        }

                        if(Auth::user()->can('customer_assign')){
                            $button = $assign;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_show'))){
                            $button = $show. $edit;
                        }

                        if((Auth::user()->can('customer_show')) && (Auth::user()->can('customer_delete'))){
                            $button = $show . $delete;
                        }

                        if((Auth::user()->can('customer_show')) && (Auth::user()->can('customer_assign'))){
                            $button = $show . $assign;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_delete'))){
                            $button = $edit . $delete;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_assign'))){
                            $button = $edit . $assign;
                        }

                        if((Auth::user()->can('customer_delete')) && (Auth::user()->can('customer_assign'))){
                            $button = $delete . $assign;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_delete')) && (Auth::user()->can('customer_show'))){
                            $button = $show. $edit . $delete;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_assign')) && (Auth::user()->can('customer_show'))){
                            $button = $show. $edit . $assign;
                        }

                        if((Auth::user()->can('customer_edit')) && (Auth::user()->can('customer_delete')) && (Auth::user()->can('customer_show')) && (Auth::user()->can('customer_assign'))){
                            $button = $show. $edit . $delete . $assign;
                        }

                        return '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$button.'
                        </ul>
                        </div>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['name','designation','company','assign','status','action'])
                    ->toJson();
            }

            $employees = User::all();
            return view('customer.index', compact('employees'));
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
        $categories = CustomerCategory::where('status', 1)->whereNull('category_id')->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        return view('customer.create', compact('divisions','categories','clientSources','clientTypes','outlets'));
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
            'name.required' => 'Enter client name',
            'primary_phone.required' => 'Enter primary phone',
            'address.required' => 'Write address',
            'division_id.required' => 'Select division',
            'district_id.required' => 'Select distinct',
            'thana_id.required' => 'Select thana',
            'client_source_id.required' => 'Select client source',
            'customer_category_id.required' => 'Select client category',
            'customer_type_id.required' => 'Select client type',
            'outlet_id.required' => 'Select outlet',
        );

        $this->validate($request, array(
            'name' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'address' => 'required',
            'thana_id' => 'required',
            'client_source_id' => 'required',
            'customer_category_id' => 'required',
            'customer_type_id' => 'required',
            'outlet_id' => 'required',
            'primary_phone' => 'required||min:8|max:15|regex:/(01)[0-9]{9}/|unique:customers,primary_phone,NULL,id,deleted_at,NULL',
            'attachment.*' => 'max:2048|mimes:jpeg,jpg,png|',
        ), $messages);

        try {
            $data = new Customer();

            if ($request->file('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/attachment'), $filename);
                $data->attachment = $filename;
            }

            $data->date                     = now()->format('Y-m-d');
            $data->name                     = $request->name;
            $data->designation              = $request->designation;
            $data->address                  = $request->address;
            $data->email                    = $request->email;
            $data->company_name             = $request->company_name;
            $data->primary_phone            = $request->primary_phone;
            $data->secondary_phone          = $request->secondary_phone;
            $data->division_id              = $request->division_id;
            $data->district_id              = $request->district_id;
            $data->thana_id                 = $request->thana_id;
            $data->client_source_id         = $request->client_source_id;
            $data->customer_category_id     = $request->customer_category_id;
            $data->customer_subcategory_id  = $request->customer_subcategory_id;
            $data->customer_type_id         = $request->customer_type_id;
            $data->outlet_id                = $request->outlet_id;
            $data->status                   = 1;
            $data->note                     = $request->note;
            $data->created_by               = Auth::user()->id;
            $data->save();

            return redirect()->route('client.index')
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
        $data = Customer::with('divisions','districits','thanas','clientSources','customerCategories','customerTypes','outlets')->findOrFail($id);
        $meetings = Meeting::with('meetingTypes')->where('customer_id',$id)->get();
        $quotations = Quotation::with('quotationTypes')->where('customer_id', $id)->get();
        $divisions = Division::where('status', 1)->get();
        $districts = District::where('status', 1)->get();
        $thanas = Thana::where('status', 1)->get();
        $categories = CustomerCategory::where('status', 1)->whereNull('category_id')->get();
        $subcategories = CustomerCategory::where('status', 1)->whereNotNull('category_id')->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        $sms = SMS::orWhere('customer_id', $id)
                ->orWhere('division_id', $data->division_id)
                ->orWhere('district_id', $data->district_id)
                ->orWhere('thana_id', $data->thana_id)
                ->orWhere('customer_source_id', $data->client_source_id)
                ->orWhere('customer_category_id', $data->customer_category_id)
                ->orWhere('customer_type_id', $data->customer_type_id)
                ->orWhere('outlet_id', $data->outlet_id)
                ->get();
        return view('customer.show', compact('divisions','categories','clientSources','clientTypes','outlets','data','districts','thanas','meetings','quotations','sms','subcategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        $divisions = Division::where('status', 1)->get();
        $districts = District::where('status', 1)->get();
        $thanas = Thana::where('status', 1)->get();
        $categories = CustomerCategory::where('status', 1)->whereNull('category_id')->get();
        $subcategories = CustomerCategory::where('id', $data->customer_subcategory_id)->where('status', 1)->whereNotNull('category_id')->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        return view('customer.edit', compact('divisions','categories','clientSources','clientTypes','outlets','data','districts','thanas','subcategories'));
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
            'name.required' => 'Enter client name',
            'primary_phone.required' => 'Enter primary phone',
            'address.required' => 'Write address',
            'division_id.required' => 'Select division',
            'district_id.required' => 'Select distinct',
            'thana_id.required' => 'Select thana',
            'client_source_id.required' => 'Select client source',
            'customer_category_id.required' => 'Select client category',
            'customer_type_id.required' => 'Select client type',
            'outlet_id.required' => 'Select outlet',
        );

        $this->validate($request, array(
            'name' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'address' => 'required',
            'thana_id' => 'required',
            'client_source_id' => 'required',
            'customer_category_id' => 'required',
            'customer_type_id' => 'required',
            'outlet_id' => 'required',
            'primary_phone' => 'required|min:11|max:11|regex:/(01)[0-9]{9}/|unique:customers,primary_phone,' . $id . ',id,deleted_at,NULL',
            'attachment.*' => 'max:2048|mimes:jpeg,jpg,png|',
        ), $messages);

        try {
            $data = Customer::findOrFail($id);

            if ($request->file('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/attachment'), $filename);
                $data->attachment = $filename;
            }else{
                $data->attachment = $request->current_image;
            }

            $data->name                     = $request->name;
            $data->designation              = $request->designation;
            $data->address                  = $request->address;
            $data->email                    = $request->email;
            $data->company_name             = $request->company_name;
            $data->primary_phone            = $request->primary_phone;
            $data->secondary_phone          = $request->secondary_phone;
            $data->division_id              = $request->division_id;
            $data->district_id              = $request->district_id;
            $data->thana_id                 = $request->thana_id;
            $data->client_source_id         = $request->client_source_id;
            $data->customer_category_id     = $request->customer_category_id;
            $data->customer_subcategory_id  = $request->customer_subcategory_id;
            $data->customer_type_id         = $request->customer_type_id;
            $data->outlet_id                = $request->outlet_id;
            $data->note                     = $request->note;
            $data->updated_by               = Auth::user()->id;
            $data->update();

            return redirect()->route('client.index')
                ->with('success', 'Data updated successfully');
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
            $data = Customer::findOrFail($id);
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
        $data = Customer::findOrFail($request->id);
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

    public function clientAssign($id)
    {
        $data = Customer::findOrFail($id);
        return response()->json($data);
    }

    public function clientAssignStore(Request $request, $id)
    {
        $data = Customer::findOrFail($id);
        $data->assign_to = $request->assign_to;
        $data->update();

        return response()->json([
            'success' => true,
            'message' => 'Client assigned successfully',
        ]);
    }

    public function customerCheck(Request $request){
        try{
            $data = Customer::where('company_name', $request->company_name)->get();
            $html = '';
            foreach($data as $key => $item){
                    $html .='<tr>
                            <th>'.($key + 1).'</th>
                            <th>'.$item->name.'</th>
                            <th>'.$item->company.'</th>
                            <th>'.$item->primary_phone.'</th>
                            <th>'.$item->email.'</th>
                        </tr>';
                    }

                return response()->json($html);

        } catch (\Exception $exception) {
            return response()->json([
                'message' =>'Data feteched failed',
            ]);
        }
    }

    public function ExcelDownload(){
        return Response::download('public/sample/customer.xlsx', 'customer.xlsx');
    }

    public function ExcelImport(Request $request)
    {
        try {
        Excel::import(new Customer(), $request->file('import_file'));
        return redirect()->back()->with('success', 'Customer imported successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function CustomerExport()
    {
        $data = Customer::all();
        return Excel::download($data, 'customer_list.xlsx');
    }
}
