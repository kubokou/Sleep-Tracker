<?php

namespace App\Http\Controllers;

use App\Models\SleepRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SleepRecordController extends Controller
{
    public function index()
    {
        $records = Auth::user()->sleepRecords()->orderBy('date')->get();
        return view('sleep.index', compact('records'));
    }

    public function create()
    {
        return view('sleep.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'sleep_time' => 'required|date_format:H:i',
            'wake_time' => 'required|date_format:H:i',
            'duration' => 'required|numeric|min:0|max:24',
            'memo' => 'nullable|string|max:500',
        ]);

        Auth::user()->sleepRecords()->create($request->all());

        return redirect()->route('sleep.index')->with('success', '睡眠記録を保存しました');
    }

    // 特定日データ取得（AJAX）
    public function getByDate(Request $request)
    {
        $date = $request->query('date');

        $record = SleepRecord::where('user_id', Auth::id())
            ->where('date', $date)
            ->first();

        return response()->json($record);
    }

    public function showByDate($date)
    {
        $user = Auth::user();
        $records = $user->sleepRecords()->whereDate('date', $date)->get();

        return view('sleep.by_date', [
            'date' => $date,
            'records' => $records,
        ]);
    }

    public function pieChart()
    {
        $now = now();
        return $this->generateChart($now->year, $now->month);
    }

    public function filterChart(Request $request)
    {
        return $this->generateChart($request->year, $request->month);
    }

    private function generateChart($year, $month)
    {
        $records = Auth::user()->sleepRecords()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // カテゴリ別睡眠時間数
        $categories = [
            '5時間未満' => 0,
            '5〜6時間' => 0,
            '6〜7時間' => 0,
            '7〜8時間' => 0,
            '8時間以上' => 0,
        ];

        foreach ($records as $r) {
            $d = $r->duration;
            if ($d < 5) $categories['5時間未満']++;
            elseif ($d < 6) $categories['5〜6時間']++;
            elseif ($d < 7) $categories['6〜7時間']++;
            elseif ($d < 8) $categories['7〜8時間']++;
            else $categories['8時間以上']++;
        }

        // 散布図データ
        $scatterPoints = [];
        foreach ($records as $r) {
            $sleep = Carbon::parse($r->sleep_time);
            $wake = Carbon::parse($r->wake_time);
            $sleepHour = $sleep->hour + $sleep->minute / 60;
            $wakeHour = $wake->hour + $wake->minute / 60;
            if ($sleepHour < 12) $sleepHour += 24;
            $scatterPoints[] = ['x' => $wakeHour, 'y' => $sleepHour];
        }

        return view('sleep.pie_chart', [
            'year' => $year,
            'month' => $month,
            'labels' => array_keys($categories),
            'values' => array_values($categories),
            'scatterPoints' => $scatterPoints,
        ]);
    }
}