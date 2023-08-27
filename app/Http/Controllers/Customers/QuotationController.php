<?php

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\QuotationType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
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
                    $data = DB::table('quotations')
                        ->leftJoin('customers','customers.id','=','quotations.customer_id')
                        ->select('customers.name','quotations.id','quotations.date','quotations.status','quotations.amount','quotations.status','quotations.quotation_no')
                        ->whereNull('quotations.deleted_at')
                        ->orderByDesc('id')
                        ->get();
                }

                if ($user_role->name == 'Supervisor') {
                    $data = DB::table('quotations')
                        ->leftJoin('users','users.id','=','quotations.created_by')
                        ->leftJoin('customers','customers.id','=','quotations.customer_id')
                        ->select('customers.name','quotations.date','quotations.status','quotations.amount','quotations.status','quotations.quotation_no','quotations.id','users.user_id')
                        ->where('quotations.created_by', $auth->id)
                        ->orWhere('users.user_id', $auth->id)
                        ->whereNull('quotations.deleted_at')
                        ->orderByDesc('id')
                        ->get();
                }

            }else{
                $data = DB::table('quotations')
                        ->leftJoin('customers','customers.id','=','quotations.customer_id')
                        ->select('customers.name','quotations.date','quotations.status','quotations.amount','quotations.status','quotations.quotation_no','quotations.id','quotations.created_by')
                        ->where('quotations.created_by', Auth::user()->id)
                        ->whereNull('quotations.deleted_at')
                        ->orderByDesc('id')
                        ->get();
                }

                return Datatables::of($data)

                    ->addColumn('status', function ($data) {

                        if($data->status == 1){
                            return '<span class="badge badge-success" title="Success">Success</span>';
                        }elseif($data->status == 2){
                            return '<span class="badge badge-info" title="Pending">Pending</span>';
                        }elseif($data->status == 3){
                            return '<span class="badge badge-danger" title="Failled">Failled</span>';
                        }else{
                            return '';
                        }
                    })

                    ->addColumn('date', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        return $date;
                    })

                    ->addColumn('action', function ($data) {

                        $button = '';

                        $show = '<li><a class="dropdown-item" href="' . route('quotations.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('quotations.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('quotations.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';

                        $status = '<a class="dropdown-item mr-5 status quotationId" id="quotationId" href="' . route('quotation.status', $data->id) . ' " title="Status" data-toggle="modal" data-target="#statusData"><i class="fa fa-stream fa-fw f-16 text-green"></i> Status</a>';

                        if(Auth::user()->can('quotation_show')){
                            $button = $show;
                        }

                        if(Auth::user()->can('quotation_edit')){
                            $button =  $edit;
                        }

                        if(Auth::user()->can('quotation_delete')){
                            $button = $delete;
                        }

                        if(Auth::user()->can('quotation_status')){
                            $button = $status;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_show'))){
                            $button = $show. $edit;
                        }

                        if((Auth::user()->can('quotation_show')) && (Auth::user()->can('quotation_delete'))){
                            $button = $show . $delete;
                        }

                        if((Auth::user()->can('quotation_show')) && (Auth::user()->can('quotation_status'))){
                            $button = $show . $status;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_delete'))){
                            $button = $edit . $delete;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_status'))){
                            $button = $edit . $status;
                        }

                        if((Auth::user()->can('quotation_delete')) && (Auth::user()->can('quotation_status'))){
                            $button = $delete . $status;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_delete')) && (Auth::user()->can('quotation_show'))){
                            $button = $show. $edit . $delete;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_status')) && (Auth::user()->can('quotation_show'))){
                            $button = $show. $edit . $status;
                        }

                        if((Auth::user()->can('quotation_edit')) && (Auth::user()->can('quotation_delete')) && (Auth::user()->can('quotation_show')) && (Auth::user()->can('quotation_status'))){
                            $button = $show. $edit . $delete . $status;
                        }

                        return '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$button.'
                        </ul>
                        </div>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action','date','status'])
                    ->toJson();
            }

            return view('quotation.index');
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
        $meetings = Meeting::all();
        $clients = Customer::where('status', 1)->get();
        $quotationTypes = QuotationType::where('status', 1)->get();
        return view('quotation.create', compact('meetings','clients','quotationTypes'));
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
            'customer_id.required' => 'Select client',
            'quotation_type_id.required' => 'Select quotation type',
            'quotation_no.required' => 'Enter quotation no',
            'date.required' => 'Enter date',
            'amount.required' => 'Enter amount',
        );

        $this->validate($request, array(
            'customer_id' => 'required',
            'quotation_type_id' => 'required',
            'quotation_no' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ), $messages);

        try {
            $data = new Quotation();
            $data->customer_id        = $request->customer_id;
            $data->meeting_id         = $request->meeting_id;
            $data->date               = $request->date;
            $data->quotation_type_id  = $request->quotation_type_id;
            $data->quotation_no       = $request->quotation_no;
            $data->amount             = $request->amount;
            $data->status             = 2;
            $data->note               = $request->note;
            $data->created_by         = Auth::user()->id;
            $data->save();

            return redirect()->route('quotations.index')
                ->with('success', 'Quotation created successfully');
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
        $data = Quotation::with('customers','meetings')->findOrFail($id);
        return view('quotation.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Quotation::findOrFail($id);
        $meetings = Meeting::all();
        $clients = Customer::where('status', 1)->get();
        $quotationTypes = QuotationType::all();
        return view('quotation.edit', compact('clients','data','meetings','quotationTypes'));
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
            'customer_id.required' => 'Select client',
            'quotation_type_id.required' => 'Select quotation type',
            'quotation_no.required' => 'Enter quotation no',
            'date.required' => 'Enter date',
            'amount.required' => 'Enter amount',
        );

        $this->validate($request, array(
            'customer_id' => 'required',
            'quotation_type_id' => 'required',
            'quotation_no' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ), $messages);

        try {
            $data = Quotation::findOrFail($id);
            $data->customer_id        = $request->customer_id;
            $data->meeting_id         = $request->meeting_id;
            $data->date               = $request->date;
            $data->quotation_type_id  = $request->quotation_type_id;
            $data->quotation_no       = $request->quotation_no;
            $data->amount             = $request->amount;
            $data->note               = $request->note;
            $data->updated_by         = Auth::user()->id;
            $data->update();

            return redirect()->route('quotations.index')
                ->with('success', 'Quotation updated successfully');
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
            $data = Quotation::findOrFail($id);
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
        $data = Quotation::findOrFail($request->id);
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

    public function quotation($id)
    {
        $data = Meeting::findOrFail($id);
        return response()->json($data);
    }

    public function quotationStore(Request $request)
    {
        if ($request->ajax()) {

            $data = Validator::make($request->all(), [
                'customer_id' => 'required',
                'meeting_id' => 'required',
                'quotation_type_id' => 'required',
                'quotation_no' => 'required',
                'date' => 'required',
                'amount' => 'required',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $data->errors()->all(),
                ]);
            }

            DB::beginTransaction();

            try {
                $data = new Quotation();
                $data->customer_id        = $request->customer_id;
                $data->meeting_id         = $request->meeting_id;
                $data->date               = $request->date;
                $data->quotation_type_id  = $request->quotation_type_id;
                $data->quotation_no       = $request->quotation_no;
                $data->amount             = $request->amount;
                $data->status             = 1;
                $data->note               = $request->note;
                $data->created_by         = Auth::user()->id;
                $data->save();

                $meeting = Meeting::where('id', $data->meeting_id)->first();
                $meeting->addquotation = 1;
                $meeting->update();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Quotation created successfully',
                ]);

            } catch (\Exception $exception) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
    }

    public function QuotationStatus($id)
    {
        $data = Quotation::findOrFail($id);
        return response()->json($data);
    }

    public function QuotationStatuStore(Request $request, $id)
    {
        $data = Quotation::findOrFail($id);
        $data->status = $request->status;
        $data->status_note = $request->status_note;
        $data->update();

        return response()->json([
            'success' => true,
            'message' => 'Meeting status updated successfully',
        ]);
    }
}
