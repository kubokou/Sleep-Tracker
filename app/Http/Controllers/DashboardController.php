<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SleepRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $records = $user->sleepRecords()
                        ->orderByDesc('date')  // 最新順に取得
                        ->take(7)              // 最新7件
                        ->get(['date', 'duration'])
                        ->sortBy('date')       // 昇順に並び替え（グラフ表示用）
                        ->values();            // インデックスをリセット

        return view('dashboard', compact('records'));
    }
}
