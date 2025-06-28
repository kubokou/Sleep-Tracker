<?php

namespace App\Http\Controllers;

use App\Models\Event; // Model追加忘れずに
class EventController extends Controller
{
    // カレンダー表示
    public function show(){
        return view("calendar/calendar");
    }
}