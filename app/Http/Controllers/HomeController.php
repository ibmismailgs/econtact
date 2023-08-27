<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Meeting;
use App\Models\MeetingMinute;
use App\Models\Quotation;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $clients = Customer::count();
        $quotations = Quotation::count();
        $meetings = Meeting::count();
        $minutes = MeetingMinute::count();
        return view('pages.dashboard', compact('clients','quotations','meetings','minutes'));
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        return view('clear-cache');
    }
}
