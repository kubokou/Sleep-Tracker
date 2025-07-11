<?php

namespace App\Http\Controllers;

use App\Models\SleepRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}