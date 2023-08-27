<?php

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CallManagement;
use App\Models\Settings\Outlet;
use App\Models\Settings\CallType;
use App\Models\Settings\Division;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\MeetingType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use App\Models\Settings\QuotationType;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Settings\CustomerCategory;

class ReportController extends Controller
{
    public function clientReport(Request $request)
    {
        try {
            if ($request->ajax()) {
                $search = Customer::query();

                if (isset($request->user_id)){
                    $search->where('created_by', $request->input('user_id'));
                }

                if (isset($request->status)){
                    $search->where('status', $request->input('status'));
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

                if (isset($request->start_date) && isset($request->end_date)){
                    $search->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
                }

                $auth = Auth::user();

                if ($auth && $auth->roles->count() > 0) {
                    $user_role = $auth->roles->first();
                if ($user_role->name == 'Super Admin') {
                    $data = $search->with('outlets')->orderByDesc('id')->get();
                } elseif ($user_role->name == 'Supervisor') {
                    $data = $search
                    ->leftJoin('users', 'users.id', '=', 'customers.created_by')
                    ->where(function ($query) use ($auth) {
                        $query->where('customers.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id);
                    })
                    ->orderByDesc('customers.id')
                    ->get();
                }
            }else {
                $data = $search->with('outlets')->where('customers.created_by', $auth->id)->orderByDesc('customers.id')->get();
                }

                $total = $data->count();
                $oldCustomer = $data->where('is_meeting', 1)->count();
                $newCustomer = $data->where('is_meeting', 0)->count();

                return Datatables::of($data)
                ->addColumn('date', function ($data) {
                    $date = Carbon::parse($data->date)->format('d-m-Y');
                    return $date;
                })

                ->addColumn('company', function ($data) {
                    $company = $data->company_name ?? '-';
                    return $company;
                })

                ->addColumn('clientStatus', function ($data) {
                    $title = $data->customerTypes->title ?? '-';
                    return $title;
                })

                ->addColumn('customerCategories', function ($data) {
                    $title = $data->customerCategories->title ?? '-';
                    return $title;
                })
                ->addColumn('outlet', function ($data) {
                    $outlet = $data->outlets->title ?? '-';
                    return $outlet;
                })

                ->addColumn('note', function ($data) {
                    $note = Str::words($data->note, 10) ?? '-';
                    return $note;
                })

                ->addColumn('action', function ($data) {
                    $button = '';
                    $show = '<a href="' . route('client.show', $data->id) . ' " class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>';

                    if(Auth::user()->can('customer_show')){
                        $button = $show;
                    }

                    return $button;
                })
                    ->addIndexColumn()
                    ->with('total', $total)
                    ->with('newCustomer', $newCustomer)
                    ->with('oldCustomer', $oldCustomer)
                    ->rawColumns(['date','company','clientStatus','customerCategories','outlet','note','action'])
                    ->toJson();
            }

            $divisions = Division::where('status', 1)->get();
            $categories = CustomerCategory::where('status', 1)->get();
            $clientSources = ClientSource::where('status', 1)->get();
            $clientTypes = CustomerType::where('status', 1)->get();
            $outlets = Outlet::where('status', 1)->get();
            $users = User::all();

            return view('reports.clientlist', compact('divisions','categories','clientSources','clientTypes','outlets','users'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function meetingReport(Request $request)
    {
        try {
            if ($request->ajax()) {

                $search = Meeting::query();

                if (isset($request->user_id)){
                    $search->where('created_by', $request->input('user_id'));
                 }

                if (isset($request->customer_id)){
                   $rr = $search->where('customer_id', $request->input('customer_id'));
                }

                if (isset($request->meeting_type_id)){
                   $search->where('meeting_type_id', $request->input('meeting_type_id'));
                }

                if (isset($request->meeting_status)){
                   $search->where('meeting_status', $request->input('meeting_status'));
                }

                if (isset($request->start_date) && isset($request->end_date)){
                    $search->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
                }

                $auth = Auth::user();

                if ($auth && $auth->roles->count() > 0) {
                    $user_role = $auth->roles->first();
                if ($user_role->name == 'Super Admin') {
                    $data = $search->with('customers','meetingTypes')->orderByDesc('id')->get();
                } elseif ($user_role->name == 'Supervisor') {
                    $data = $search
                    ->leftJoin('users', 'users.id', '=', 'meetings.created_by')
                    ->where(function ($query) use ($auth) {
                        $query->where('meetings.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id);
                    })
                    ->orderByDesc('meetings.id')
                    ->get();
                }
            }else {
                $data = $search->with('customers','meetingTypes')->where('created_by', Auth::user()->id)
                    ->orderByDesc('id')
                    ->get();
                }

                    $totalMeeting = $data->count();
                    $totalSuccess = $data->where('meeting_status', 1)->count();
                    $totalPending = $data->where('meeting_status', 2)->count();
                    $totalFail = $data->where('meeting_status', 3)->count();
                    $oldMeeting = $data->where('is_reschedule', 1)->count();
                    $newMeeting = $data->where('is_reschedule', 0)->count();

                return Datatables::of($data)

                    ->addColumn('dateTime', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        $time = date('g:i a', strtotime($data->time));
                        return $date . ' | ' . $time;
                    })

                    ->addColumn('company', function ($data) {
                        $company = $data->customers->company_name ?? '-';
                        return $company;
                    })

                    ->addColumn('type', function ($data) {
                        $title = $data->meetingTypes->title ?? '-';
                        return $title;
                    })

                    ->addColumn('status', function ($data) {
                        if($data->meeting_status == 1){
                            return '<span class="badge badge-success" title="Success">Success</span>';
                        }elseif($data->meeting_status == 2){
                            return '<span class="badge badge-info" title="Pending">Pending</span>';
                        }elseif($data->meeting_status == 3){
                            return '<span class="badge badge-danger" title="Failled">Failled</span>';
                        }else{
                            return '';
                        }
                    })

                    ->addColumn('user', function ($data) {
                        $name = $data->created_by ?? '-';
                        return $name;
                    })

                    ->addColumn('client', function ($data) {
                        $name = $data->customers->name ?? '-';
                        return $name;
                    })

                    ->addColumn('note', function ($data) {
                        $note = Str::words($data->status_note, 10) ?? '-';
                        return $note;
                    })

                    ->addColumn('action', function ($data) {
                        $button = '';
                        $show = '<a href="' . route('meeting.show', $data->id) . ' " class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>';

                        if(Auth::user()->can('customer_show')){
                            $button = $show;
                        }

                        return $button;
                    })

                    ->addIndexColumn()
                    ->with('totalMeeting', $totalMeeting)
                    ->with('newMeeting', $newMeeting)
                    ->with('oldMeeting', $oldMeeting)
                    ->with('totalSuccess', $totalSuccess)
                    ->with('totalPending', $totalPending)
                    ->with('totalFail', $totalFail)
                    ->rawColumns(['dateTime','type','company','status','note','user','client','action'])
                    ->toJson();
                }

            $clients = Customer::where('is_meeting', 1)->get();
            $meetingTypes = MeetingType::where('status', 1)->get();
            $users = User::all();
            return view('reports.meeting_report', compact('meetingTypes','clients','users'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function quotationReport(Request $request)
    {
        try {
            if ($request->ajax()) {

                $search = Quotation::query();

                if (isset($request->user_id)){
                    $search->where('created_by', $request->input('user_id'));
                 }

                if (isset($request->customer_id)){
                    $search->where('customer_id', $request->input('customer_id'));
                }

                if (isset($request->quotation_type_id)){
                   $search->where('quotation_type_id', $request->input('quotation_type_id'));
                }

                if (isset($request->start_date) && isset($request->end_date)){
                    $search->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
                }

                $auth = Auth::user();

                if ($auth && $auth->roles->count() > 0) {
                    $user_role = $auth->roles->first();
                if ($user_role->name == 'Super Admin') {
                    $data = $search->with('customers','meetings')->orderByDesc('id')->get();
                } elseif ($user_role->name == 'Supervisor') {
                    $data = $search
                    ->leftJoin('users', 'users.id', '=', 'quotations.created_by')
                    ->where(function ($query) use ($auth) {
                        $query->where('quotations.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id);
                    })
                    ->orderByDesc('quotations.id')
                        ->get();
                    }
                }else {
                    $data = $search->with('customers','meetings')->where('created_by', Auth::user()->id)
                        ->orderByDesc('id')
                        ->get();
                    }

                $total = $search->sum('amount');
                $totalQuotation = $data->count();
                $totalSuccess = $data->where('status', 1)->count();
                $totalPending = $data->where('status', 2)->count();
                $totalFail = $data->where('status', 3)->count();


                return Datatables::of($data)

                    ->addColumn('date', function ($data) {
                        $date = Carbon::parse($data->date)->format('d-m-Y');
                        return $date;
                    })


                    ->addColumn('company', function ($data) {
                        $company = $data->customers->company_name ?? '-';
                        return $company;
                    })

                    ->addColumn('status', function ($data) {

                        if($data->status == 1){
                            return '<span class="badge badge-success" title="Success">Success</span>';
                        }elseif($data->status == 2){
                            return '<span class="badge badge-info" title="Pending">Pending</span>';
                        }elseif($data->status == 3){
                            return '<span class="badge badge-danger" title="Failled">Failled</span>';
                        }else{
                            return '-';
                        }

                    })

                    ->addColumn('type', function ($data) {
                        $title = $data->quotationTypes->title ?? '-';
                        return $title;
                    })

                    ->addColumn('amount', function ($data) {
                        $amount =  number_format($data->amount, 2);
                        return $amount;
                    })

                    ->addColumn('client', function ($data) {
                        $name = $data->customers->name ?? '-';
                        return $name;
                    })

                    ->addColumn('note', function ($data) {
                        $note = Str::words($data->note, 10) ?? '-';
                        return $note;
                    })

                    ->addColumn('action', function ($data) {
                        $button = '';
                        $show = '<a href="' . route('meeting.show', $data->id) . ' " class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>';

                        if(Auth::user()->can('customer_show')){
                            $button = $show;
                        }

                        return $button;
                    })

                    ->addIndexColumn()
                    ->with('totalAmount', number_format($total, 2))
                    ->with('totalQuotation', $totalQuotation)
                    ->with('totalSuccess', $totalSuccess)
                    ->with('totalPending', $totalPending)
                    ->with('totalFail', $totalFail)
                    ->rawColumns(['date','company','client','amount','type','note','status','action'])
                    ->toJson();
                }

            $clients = Customer::where('status', 1)->get();
            $quotationTypes = QuotationType::where('status', 1)->get();
            $users = User::all();
            $auth = Auth::user();
            $user_role = $auth->roles->first();
            return view('reports.quotation_report', compact('quotationTypes','clients','users','user_role'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function callReport(Request $request)
    {
        try {
            if ($request->ajax()) {

                $search = CallManagement::query();

                if (isset($request->user_id)){
                    $search->where('created_by', $request->input('user_id'));
                 }

                if (isset($request->customer_id)){
                    $search->where('customer_id', $request->input('customer_id'));
                }

                if (isset($request->call_type_id)){
                   $search->where('call_type_id', $request->input('call_type_id'));
                }

                if (isset($request->start_date) && isset($request->end_date)){
                    $search->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
                }

                $auth = Auth::user();

                if ($auth && $auth->roles->count() > 0) {
                    $user_role = $auth->roles->first();
                if ($user_role->name == 'Super Admin') {
                    $data = $search->with('customers','callTypes')->orderByDesc('id')->get();
                } elseif ($user_role->name == 'Supervisor') {
                    $data = $search
                    ->leftJoin('users', 'users.id', '=', 'call_management.created_by')
                    ->where(function ($query) use ($auth) {
                        $query->where('call_management.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id);
                    })
                    ->orderByDesc('call_management.id')
                    ->get();
                }
            }else {
                $data = $search->with('customers','callTypes')->where('created_by', Auth::user()->id)
                    ->orderByDesc('id')
                    ->get();
                }

                $total = $data->count();
                $newCall = $data->where('re_call', 1)->count();
                $oldCall = $data->where('re_call', 0)->count();

                return Datatables::of($data)

                    ->addColumn('dateTime', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        $time = date('g:i a', strtotime($data->time));
                        return $date . ' | ' . $time;
                    })

                    ->addColumn('company', function ($data) {
                        $company = $data->customers->company_name ?? '-';
                        return $company;
                    })

                    ->addColumn('phone', function ($data) {
                        $phone = $data->customers->primary_phone ?? '-';
                        return $phone;
                    })

                    ->addColumn('callType', function ($data) {
                        $title = $data->callTypes->title ?? '-';
                        return $title;
                    })

                    ->addColumn('client', function ($data) {
                        $name = $data->customers->name ?? '-';
                        return $name;
                    })

                    ->addColumn('note', function ($data) {
                        $note = Str::words($data->note, 10) ?? '-';
                        return $note;
                    })

                    ->addColumn('action', function ($data) {
                        $button = '';
                        $show = '<a href="' . route('call-management.show', $data->id) . ' " class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i></a>';

                        if(Auth::user()->can('customer_show')){
                            $button = $show;
                        }

                        return $button;
                    })

                    ->addIndexColumn()
                    ->with('total', $total)
                    ->with('newCall', $newCall)
                    ->with('oldCall', $oldCall)
                    ->rawColumns(['dateTime','company','client','callType','note','action','phone'])
                    ->toJson();
                }

            $clients = Customer::where('status', 1)->get();
            $callTypes = CallType::where('status', 1)->get();
            $users = User::all();
            return view('reports.call_report', compact('callTypes','clients','users'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
