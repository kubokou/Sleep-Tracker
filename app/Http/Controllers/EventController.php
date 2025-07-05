<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // カレンダービューを表示
    public function show()
    {
        $user = Auth::user();
        $sleepRecords = $user -> sleepRecords;
        return view("calendar/calendar")->with(['sleepRecords' => $sleepRecords]);
    }

    // イベント登録処理
    public function create(Request $request, Event $event)
    {
        // バリデーション（NULL不可のカラムに対応）
        $request->validate([
            'event_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_color' => 'required|string',
        ]);

        // イベント保存（終了日を+1日しない）
        $event->event_title = $request->input('event_title');
        $event->event_body = $request->input('event_body');
        $event->start_date = $request->input('start_date');
        $event->end_date = $request->input('end_date');
        $event->event_color = $request->input('event_color');
        $event->event_border_color = $request->input('event_color');
        $event->save();

        // 登録後にカレンダー画面へリダイレクト
        return redirect()->route("show");
    }

    // イベント取得処理（AJAX）
    public function get(Request $request, Event $event)
    {
        // バリデーション（JSから送られるのはミリ秒タイムスタンプ）
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        // JSのミリ秒 → 秒 → 日付に変換
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // 対象期間のイベント取得
        return $event->query()
            ->select(
                'id',
                'event_title as title',
                'event_body as description',
                'start_date as start',
                'end_date as end',
                'event_color as backgroundColor',
                'event_border_color as borderColor',
                \DB::raw('true as allDay') // すべて終日扱い（FullCalendar用）
            )
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->get();
    }
}
