<?php

namespace App\Http\Controllers\Customers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Models\MeetingMinute;
use App\Http\Controllers\Controller;
use App\Models\MeetingReschedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeetingMinutesController extends Controller
{
    public function meetingMinute($id)
    {
        $data = Meeting::findOrFail($id);
        return response()->json($data);
    }

    public function meetingMinuteStore(Request $request)
    {
        if ($request->ajax()) {

            $data = Validator::make($request->all(), [
                'date' => 'required',
                'time' => 'required',
                'meeting_id' => 'required',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $data->errors()->all(),
                ]);
            }

            try {
                $data = new MeetingMinute();
                $data->meeting_id = $request->meeting_id;
                $data->date = $request->date;
                $data->time = $request->time;
                $data->note = $request->note;
                $data->created_by = Auth::user()->id;
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Meeting minute created successfully',
                ]);

            } catch (\Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }

    }
    public function meetingReschedule($id)
    {
        $data = Meeting::findOrFail($id);
        return response()->json($data);
    }

    public function meetingRescheduleStore(Request $request)
    {
        if ($request->ajax()) {

            $data = Validator::make($request->all(), [
                'date' => 'required',
                'time' => 'required',
                'meeting_id' => 'required',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $data->errors()->all(),
                ]);
            }

            try {
                $data = new MeetingReschedule();
                $data->meeting_id = $request->meeting_id;
                $data->date = $request->date;
                $data->time = $request->time;
                $data->note = $request->note;
                $data->created_by = Auth::user()->id;
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Meeting reschedule created successfully',
                ]);

            } catch (\Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
    }
}
