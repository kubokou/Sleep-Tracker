<!-- calendar.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FullCalendar</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

    <!-- app用CSSとJS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #calendar {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="container mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold mb-6 text-center">カレンダーで睡眠記録を見る</h2>

        <!-- カレンダー -->
        <div id='calendar'></div>

        <!-- 戻るボタン -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('dashboard') }}">
                <x-primary-button class="bg-black hover:bg-gray-800 text-white">
                    ダッシュボードに戻る
                </x-primary-button>
            </a>
        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <!-- axios (AJAX) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ja',
                selectable: true,
                dateClick: function (info) {
                    const date = info.dateStr;

                    axios.get('/sleep/by-date', {
                        params: { date: date }
                    })
                    .then(response => {
                        const data = response.data;
                        if (data) {
                            alert(
                                【${date}の記録】\n +
                                就寝時間: ${data.sleep_time}\n +
                                起床時間: ${data.wake_time}\n +
                                睡眠時間: ${data.duration} 時間\n +
                                メモ: ${data.memo || 'なし'}
                            );
                        } else {
                            alert(${date} の記録はありません。);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('データの取得に失敗しました。');
                    });
                }
            });

            calendar.render();
        });
    </script>
</body>
</html> 
