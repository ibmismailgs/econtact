<?php

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\MeetingMinute;
use App\Models\MeetingReschedule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\MeetingType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\QuotationType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
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
                        $data = DB::table('meetings')
                            ->leftJoin('customers','customers.id','=','meetings.customer_id')
                            ->leftJoin('meeting_types','meeting_types.id','=','meetings.meeting_type_id')
                            ->select('customers.name','meetings.id','meeting_types.title','meetings.date','meetings.time','meetings.meeting_status','meetings.is_reschedule')
                            ->whereNull('meetings.deleted_at')
                            ->orderByDesc('id')
                            ->get();
                    }

                    if ($user_role->name == 'Supervisor') {

                        $data = DB::table('meetings')
                            ->leftJoin('users','users.id','=','meetings.created_by')
                            ->leftJoin('customers','customers.id','=','meetings.customer_id')
                            ->leftJoin('meeting_types','meeting_types.id','=','meetings.meeting_type_id')
                            ->select('customers.name','meetings.id','meeting_types.title','meetings.date','meetings.time','meetings.meeting_status','meetings.is_reschedule','users.user_id')
                            ->where('meetings.created_by', $auth->id)
                            ->orWhere('users.user_id', $auth->id)
                            ->whereNull('meetings.deleted_at')
                            ->orderByDesc('id')
                            ->get();

                    }

                }else{
                    $data = DB::table('meetings')
                            ->leftJoin('customers','customers.id','=','meetings.customer_id')
                            ->leftJoin('meeting_types','meeting_types.id','=','meetings.meeting_type_id')
                            ->select('customers.name','meetings.id','meeting_types.title','meetings.date','meetings.time','meetings.meeting_status','meetings.is_reschedule')
                            ->where('meetings.created_by', Auth::user()->id)
                            ->whereNull('meetings.deleted_at')
                            ->orderByDesc('id')
                            ->get();
                    }

                return Datatables::of($data)
                    ->addColumn('meetingStatus', function ($data) {

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

                    ->addColumn('dateTime', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        $time = date('g:i a', strtotime($data->time));
                        return $date . ' | ' . $time;
                    })

                    ->addColumn('action', function ($data) {

                        $button = '';

                        $show = '<li><a class="dropdown-item" href="' . route('meeting.show', $data->id) . ' " ><i class="ik ik-eye f-16 text-blue"></i> Details</a></li>';

                        $edit = '<li><a class="dropdown-item" id="edit" href="' . route('meeting.edit', $data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i> Edit</a></li>';

                        $delete = '<li><a class="dropdown-item" id="delete" href="' . route('meeting.destroy', $data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i> Delete</a></li>';

                        $status = '<a class="dropdown-item mr-5 status meetingId" id="meetingId" href="' . route('meeting.status', $data->id) . ' " title="Status" data-toggle="modal" data-target="#statusData"><i class="fa fa-stream fa-fw f-16 text-green"></i> Status</a>';

                        $minute = '<a class="dropdown-item mr-5 status meetingMinute" id="minuteId" href="' . route('meeting-minute', $data->id) . ' " title="Status" data-toggle="modal" data-target="#minuteData"><i class="fa fa-handshake f-16 text-green"></i> Minutes</a>';

                        $reschedule = '<a class="dropdown-item mr-5 meetingReschedule" id="RescheduleId" href="' . route('meeting-reschedule', $data->id) . ' " title="Reschedule" data-toggle="modal" data-target="#RescheduleData"><i class="fa fa-calendar f-16 text-blue"></i> Reschedule</a>';

                        $quotation = '<a class="dropdown-item mr-5 quotation" id="quotationId" href="' . route('quotation', $data->id) . ' " title="Quotation" data-toggle="modal" data-target="#quotationData"><i class="fa fa-sticky-note f-16 text-blue"></i> Quotation</a>';

                        if(Auth::user()->can('meeting_show')){
                            $button = $show;
                        }

                        if(Auth::user()->can('meeting_edit')){
                            $button =  $edit;
                        }

                        if(Auth::user()->can('meeting_delete')){
                            $button = $delete;
                        }

                        if(Auth::user()->can('meeting_status')){
                            $button = $status;
                        }

                        if(Auth::user()->can('meeting_minutes')){
                            $button = $minute;
                        }

                        if(Auth::user()->can('meeting_reschedule')){
                            $button = $reschedule;
                        }

                        if(Auth::user()->can('meeting_quotation')){
                            $button = $quotation;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit;
                        }

                        if((Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_delete'))){
                            $button = $show . $delete;
                        }

                        if((Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_status'))){
                            $button = $show . $status;
                        }

                        if((Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $show . $minute;
                        }

                        if((Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $show . $reschedule;
                        }

                        if((Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $show . $quotation;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_delete'))){
                            $button = $edit . $delete;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_status'))){
                            $button = $edit . $status;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $edit . $minute;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $edit . $reschedule;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $edit . $quotation;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_status'))){
                            $button = $delete . $status;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $delete . $minute;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $delete . $reschedule;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $delete . $quotation;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $status . $minute;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $status . $reschedule;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $status . $quotation;
                        }

                        if((Auth::user()->can('meeting_reschedule')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $minute . $reschedule;
                        }

                        if((Auth::user()->can('meeting_quotation')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $minute . $quotation;
                        }

                        if((Auth::user()->can('meeting_quotation')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $reschedule . $quotation;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit . $delete;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit . $status;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_minutes')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit . $minute;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_reschedule')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit . $reschedule;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_quotation')) && (Auth::user()->can('meeting_show'))){
                            $button = $show. $edit . $quotation;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_status'))){
                            $button = $show. $delete . $status;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $show. $delete . $minute;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $show. $delete . $reschedule;
                        }

                        if((Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $show. $delete . $quotation;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_minutes'))){
                            $button = $show. $status . $minute;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $show. $status . $reschedule;
                        }

                        if((Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $show. $status . $quotation;
                        }

                        if((Auth::user()->can('meeting_minutes')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_quotation'))){
                            $button = $show. $minute . $quotation;
                        }

                        if((Auth::user()->can('meeting_minutes')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $show. $minute . $reschedule;
                        }

                        if((Auth::user()->can('meeting_quotation')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_reschedule'))){
                            $button = $show. $reschedule . $quotation;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_status'))){
                            $button = $show. $edit . $delete . $status;
                        }

                        if((Auth::user()->can('meeting_edit')) && (Auth::user()->can('meeting_delete')) && (Auth::user()->can('meeting_show')) && (Auth::user()->can('meeting_status')) && (Auth::user()->can('meeting_minutes')) && (Auth::user()->can('meeting_reschedule')) && (Auth::user()->can('meeting_quotation'))){
                            $button =  $show . $edit . $delete . $status . $minute . $reschedule . $quotation;
                        }

                        return '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$button.'
                        </ul>
                        </div>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status','action','dateTime','meetingStatus'])
                    ->toJson();
            }

            $quotationTypes = QuotationType::where('status', 1)->get();
            return view('meeting.index', compact('quotationTypes'));
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
        $meetingTypes = MeetingType::where('status', 1)->get();
        $clients = Customer::where('status', 1)->get();
        $quotationTypes = QuotationType::where('status', 1)->get();
        return view('meeting.create', compact('meetingTypes','clients','quotationTypes'));
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
            'title.required' => 'Enter meeting title',
            'customer_id.required' => 'Select client',
            'meeting_type_id.required' => 'Select meeting type',
            'date.required' => 'Enter date',
            'time.required' => 'Enter time',
        );

        $this->validate($request, array(
            'title' => 'required',
            'customer_id' => 'required',
            'meeting_type_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {

            $existMeeting = Meeting::where('customer_id', $request->customer_id)->first();
            $data = new Meeting();
            if($existMeeting){
                $data->is_reschedule = 1;
                $existMeeting->is_reschedule = 1;
                $existMeeting->update();
            }else{
                $data->is_reschedule = 0;
            }

            // if($request->addquotation == 1){
            //     $data->addquotation = 1;
            // }else{
            //     $data->addquotation = 0;
            // }


            $data->title            = $request->title;
            $data->customer_id      = $request->customer_id;
            $data->meeting_type_id  = $request->meeting_type_id;
            $data->date             = $request->date;
            $data->time             = $request->time;
            $data->reschedule_date  = $request->reschedule_date;
            $data->note             = $request->note;
            $data->created_by       = Auth::user()->id;
            $data->save();

            // if($request->addquotation == 1){
            //     $quotation = new Quotation();
            //     $quotation->customer_id        = $request->customer_id;
            //     $quotation->meeting_id         = $data->id;
            //     $quotation->date               = $request->date;
            //     $quotation->quotation_type_id  = $request->quotation_type_id;
            //     $quotation->quotation_no       = $request->quotation_no;
            //     $quotation->amount             = $request->amount;
            //     $quotation->status             = 1;
            //     $quotation->note               = $request->note;
            //     $quotation->created_by         = Auth::user()->id;
            //     $quotation->save();
            // }

            $customer = Customer::where('id', $data->customer_id)->first();
            $customer->is_meeting = 1;
            $customer->update();

            DB::commit();

            return redirect()->route('meeting.index')
                ->with('success', 'Data created successfully');
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
        $data = Meeting::with('customers','meetingTypes')->findOrFail($id);
        $quotations = Quotation::with('quotationTypes')->where('meeting_id', $data->id)->get();
        $meetingMinutes = MeetingMinute::with('meetings')->where('meeting_id', $data->id)->get();
        $meetingReschedules = MeetingReschedule::with('meetings')->where('meeting_id', $data->id)->get();
        return view('meeting.show', compact('data','quotations','meetingMinutes','meetingReschedules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Meeting::findOrFail($id);
        $meetingTypes = MeetingType::where('status', 1)->get();
        $clients = Customer::where('status', 1)->get();
        $customers = Customer::where('status', 1)->get();
        $quotationTypes = QuotationType::where('status', 1)->get();
        $quotation = Quotation::where('meeting_id', $id)->first();
        return view('meeting.edit', compact('meetingTypes','clients','customers','quotationTypes','data','quotation'));
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
            'title.required' => 'Enter meeting title',
            'customer_id.required' => 'Select client',
            'meeting_type_id.required' => 'Select meeting type',
            'date.required' => 'Enter date',
            'time.required' => 'Enter time',
        );

        $this->validate($request, array(
            'title' => 'required',
            'customer_id' => 'required',
            'meeting_type_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = Meeting::findOrFail($id);

            // if($request->addquotation == 1){
            //     $data->addquotation = 1;
            // }else{
            //     $data->addquotation = 0;
            // }

            $data->title            = $request->title;
            $data->customer_id      = $request->customer_id;
            $data->meeting_type_id  = $request->meeting_type_id;
            $data->date             = $request->date;
            $data->time             = $request->time;
            $data->is_reschedule    = $request->is_reschedule;
            $data->reschedule_date  = $request->reschedule_date;
            $data->note             = $request->note;
            $data->updated_by       = Auth::user()->id;
            $data->update();

            // if($data->addquotation == 1){
            //     $quotation = Quotation::where('meeting_id', $id)->first();
            //     $quotation->customer_id        = $request->customer_id;
            //     $quotation->meeting_id         = $data->id;
            //     $quotation->date               = $request->date;
            //     $quotation->quotation_type_id  = $request->quotation_type_id;
            //     $quotation->quotation_no       = $request->quotation_no;
            //     $quotation->amount             = $request->amount;
            //     $quotation->note               = $request->note;
            //     $quotation->updated_by         = Auth::user()->id;
            //     $quotation->update();
            // }

            // if($data->addquotation == 1){
            //     $quotation = new Quotation();
            //     $quotation->customer_id        = $request->customer_id;
            //     $quotation->meeting_id         = $data->id;
            //     $quotation->date               = $request->date;
            //     $quotation->quotation_type_id  = $request->quotation_type_id;
            //     $quotation->quotation_no       = $request->quotation_no;
            //     $quotation->amount             = $request->amount;
            //     $quotation->note               = $request->note;
            //     $quotation->updated_by         = Auth::user()->id;
            //     $quotation->save();
            // }

            DB::commit();

            return redirect()->route('meeting.index')
                ->with('success', 'Data created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
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
            $data = Meeting::findOrFail($id);
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

    public function MeetingStatus($id)
    {
        $data = Meeting::findOrFail($id);
        return response()->json($data);
    }

    public function meetingStatustore(Request $request, $id)
    {
        $data = Meeting::findOrFail($id);
        $data->meeting_status = $request->meeting_status;
        $data->status_note = $request->status_note;
        $data->update();

        return response()->json([
            'success' => true,
            'message' => 'Meeting status updated successfully',
        ]);
    }
}
