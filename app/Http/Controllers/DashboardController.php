<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SleepRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $records = $user->sleepRecords()
                        ->orderBy('date')
                        ->get(['date', 'duration']); // 必要なデータのみ取得

        return view('dashboard', compact('records'));
    }
}
