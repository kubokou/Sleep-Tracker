// calendar.js

import axios from "axios";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from "@fullcalendar/interaction";

const sleepRecords = window.data.sleepRecords;
const events = [
    sleepRecords.map((sleepRecord) => ({
		id: sleepRecord.id,
		start: sleepRecord.date,
		end: "",
		title: "睡眠記録",
		description: sleepRecord.sleep_time,
		backgroundColor: "red",
		borderColor: "red",
		editable: true
    }))];

// すでに初期化済みなら再描画しない（ページ遷移対応やViteのHMR防止にも役立つ）
if (!window.fullCalendarInitialized) {
    const calendarEl = document.getElementById("calendar");
    console.log(events[0]);
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: "dayGridMonth",
            events: events[0],
            eventClick: (e)=>{
                window.location.href = "/dashboard";
	    },
            headerToolbar: {
                start: "prev,next today",
                center: "title",
                end: "eventAddButton dayGridMonth,timeGridWeek",
            },
            height: "auto",
        });

        calendar.render();
    }
}

