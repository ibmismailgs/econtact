<?php

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\EmailSend;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailMarketing;
use App\Models\Settings\Thana;
use App\Models\Settings\Outlet;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Settings\CustomerCategory;

class EmailController extends Controller
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
                        $data = DB::table('email_marketings')
                            ->select('id','customer_id','text','status','type')
                            ->whereNull('deleted_at')
                            ->orderByDesc('id')
                            ->get();

                    } elseif ($user_role->name == 'Supervisor') {
                        $data = DB::table('email_marketings')
                            ->leftJoin('users','users.id','=','email_marketings.created_by')
                            ->select('email_marketings.id','email_marketings.customer_id','email_marketings.text','email_marketings.status','email_marketings.type','users.user_id')
                            ->where('email_marketings.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id)
                            ->whereNull('deleted_at')
                            ->orderByDesc('id')
                            ->get();
                    }

                }else {
                    $data = DB::table('email_marketings')
                        ->select('id','customer_id','text','status','type')
                        ->where('created_by', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->orderByDesc('id')
                        ->get();
                }

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {

                    if (Auth::user()->can('email_status')) {
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

                        $show = '<li><a class="dropdown-item" href="' . route('email-marketing.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('email-marketing.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('email-marketing.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';


                        if(Auth::user()->can('email_show')){
                            $button = $show;
                        }

                        if(Auth::user()->can('email_edit')){
                            $button =  $edit;
                        }

                        if(Auth::user()->can('email_delete')){
                            $button = $delete;
                        }

                        if((Auth::user()->can('email_edit')) && (Auth::user()->can('email_show'))){
                            $button = $show. $edit;
                        }

                        if((Auth::user()->can('email_edit')) && (Auth::user()->can('email_delete'))){
                            $button = $edit . $delete;
                        }

                        if((Auth::user()->can('email_show')) && (Auth::user()->can('email_delete'))){
                            $button = $show . $delete;
                        }

                        if((Auth::user()->can('email_edit')) && (Auth::user()->can('email_delete')) && (Auth::user()->can('email_show'))){
                            $button = $show. $edit . $delete;
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

            return view('email.index');
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
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $users = User::all();
        return view('email.create', compact('divisions','categories','clientSources','clientTypes','outlets','clients','users','user_role'));
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
            'type.required' => 'Select email type',
            'text.required' => 'Write email details',
        );

        $this->validate($request, array(
            'type' => 'required',
            'text' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new EmailMarketing();
            $data->user_id                  = $request->user_id;
            $data->customer_id              = $request->customer_id;
            $data->type                     = $request->type;
            $data->division_id              = $request->division_id;
            $data->district_id              = $request->district_id;
            $data->thana_id                 = $request->thana_id;
            $data->customer_source_id       = $request->customer_source_id;
            $data->customer_category_id     = $request->customer_category_id;
            $data->customer_subcategory_id  = $request->customer_subcategory_id;
            $data->customer_type_id         = $request->customer_type_id;
            $data->outlet_id                = $request->outlet_id;
            $data->text                     = $request->text;
            $data->status                   = 1;
            $data->created_by               = Auth::user()->id;
            $data->save();

            // if($data->type == 1){
            //     $client = EmailMarketing::findOrFail($data->id);
            //     $email = $data->customers->email;
            //     Mail::to($email)->send(new EmailSend($client, $email));
            // }

            if($data->type == 2){

                $search = Customer::where('status', 1);

                if (isset($request->user_id)){
                   $search->where('created_by', $request->input('user_id'));
                }

                if (isset($request->division_id)){
                   $search->where('division_id', $request->input('division_id'));
                }

                if (isset($request->district_id)){
                   $search->where('district_id', $request->input('district_id'));
                }

                if (isset($request->thana_id)){
                   $search->where('thana_id', $request->input('thana_id'));
                }

                if (isset($request->client_source_id)){
                   $search->where('client_source_id', $request->input('client_source_id'));
                }

                if (isset($request->customer_category_id)){
                   $search->where('customer_category_id', $request->input('customer_category_id'));
                }

                if (isset($request->customer_subcategory_id)){
                   $search->where('customer_subcategory_id', $request->input('customer_subcategory_id'));
                }

                if (isset($request->customer_type_id)){
                   $search->where('customer_type_id', $request->input('customer_type_id'));
                }

                if (isset($request->outlet_id)){
                   $search->where('outlet_id', $request->input('outlet_id'));
                }

                $auth = Auth::user();
                $user_role = $auth->roles->first();

                if ($user_role->name == 'Super Admin') {
                    $clients = $search->get();

                }else{
                    $clients = $search->where('created_by', Auth::user()->id)
                    ->get();
                }

                // foreach($clients as $client){
                //     $client = EmailMarketing::where('customer_id', $client->id)->first();
                //     $email = $client->customers->email;
                //     Mail::to($email)->send(new EmailSend($client, $email));
                // }
            }

            DB::commit();

            return redirect()->route('email-marketing.index')
                ->with('success', 'Email created successfully');
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
        $data = EmailMarketing::with('divisions','districits','thanas','clientSources','customerCategories','customerTypes','outlets','customers')->findOrFail($id);

        if($data->type == 2){

            $search = Customer::query();

            if (isset($data->user_id)){
               $search->where('created_by', $data->user_id);
            }

            if (isset($data->division_id)){
               $search->where('division_id', $data->division_id);
            }

            if (isset($data->district_id)){
               $search->where('district_id', $data->district_id);
            }

            if (isset($data->thana_id)){
               $search->where('thana_id', $data->thana_id);
            }

            if (isset($data->client_source_id)){
               $search->where('client_source_id', $data->client_source_id);
            }

            if (isset($data->customer_category_id)){
               $search->where('customer_category_id', $data->customer_category_id);
            }

            if (isset($data->customer_subcategory_id)){
               $search->where('customer_subcategory_id', $data->customer_subcategory_id);
            }

            if (isset($data->customer_type_id)){
               $search->where('customer_type_id', $data->customer_type_id);
            }

            if (isset($data->outlet_id)){
               $search->where('outlet_id', $data->outlet_id);
            }

             $auth = Auth::user();
             $user_role = $auth->roles->first();

            if ($user_role->name == 'Super Admin') {
                $clients = $search->get();

            }else{
                $clients = $search->where('created_by', Auth::user()->id)
                ->get();
            }
        }else{
            $clients = '';
        }
        return view('email.show', compact('data','clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = EmailMarketing::findOrFail($id);
        $divisions = Division::where('status', 1)->get();
        $districts = District::where('status', 1)->get();
        $thanas = Thana::where('status', 1)->get();
        $categories = CustomerCategory::where('status', 1)->whereNull('category_id')->get();
        $subcategories = CustomerCategory::where('id', $data->customer_subcategory_id)->where('status', 1)->whereNotNull('category_id')->get();
        $clientSources = ClientSource::where('status', 1)->get();
        $clientTypes = CustomerType::where('status', 1)->get();
        $outlets = Outlet::where('status', 1)->get();
        $clients = Customer::where('status', 1)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $users = User::all();
        return view('email.edit', compact('divisions','categories','clientSources','clientTypes','outlets','clients','data','districts','thanas','subcategories','user_role','users'));
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
            'type.required' => 'Select sms type',
            'text.required' => 'Write text details',
        );

        $this->validate($request, array(
            'type' => 'required',
            'text' => 'required',
        ), $messages);

        try {
            $data = EmailMarketing::findOrFail($id);
            $data->user_id                  = $request->user_id;
            $data->customer_id              = $request->customer_id;
            $data->type                     = $request->type;
            $data->division_id              = $request->division_id;
            $data->district_id              = $request->district_id;
            $data->thana_id                 = $request->thana_id;
            $data->customer_source_id       = $request->customer_source_id;
            $data->customer_category_id     = $request->customer_category_id;
            $data->customer_subcategory_id  = $request->customer_subcategory_id;
            $data->customer_type_id         = $request->customer_type_id;
            $data->outlet_id                = $request->outlet_id;
            $data->text                     = $request->text;
            $data->updated_by               = Auth::user()->id;
            $data->update();

            return redirect()->route('email-marketing.index')
                ->with('success', 'Email updated successfully');
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
            $data = EmailMarketing::findOrFail($id);
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
        $data = EmailMarketing::findOrFail($request->id);
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
