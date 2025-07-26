<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SleepTrackerへようこそ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url("https://msp.c.yimg.jp/images/v2/FUTi93tXq405grZVGgDqG5tJgvQ5e0zR1JPjBnSOg6u0o-oAEopDfLn5Y_N3oVi2cpUowXIlLzO1yH60HbW2BH3uSc6ZqXkzoN2GVRd7LFQ3I_3djQDRZHTj5PuRl-Qw1M0lwHwTI7X7dT0S6L8X-6wB2P6J-ZTkPRPbLztpNUqYogesQP_aXyb8MQ21jl1ay4iZTldufLUyozbcCsSNUXQ5MvEf0XBjEQjyHwNNmngp2Nv4DDN2qBE5H8xKf-M9PtPqLQYj_K5Lgj3Lc3G3EKshHaUck4YFHfRp7htU0U8=/8930cfc0252ec84181dc84fe3279b39a.png?errorImage=false") no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
            position: relative;
        }

        .moon {
            position: absolute;
            top: 60px;
            right: 80px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle at 30% 30%, #fdf6e3, #b2b2b2);
            border-radius: 50%;
            box-shadow: 0 0 20px 5px #fefbd8;
            z-index: 1;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative text-white">
    <!-- 背景装飾 -->
    <div class="moon"></div>

    <!-- 中央コンテンツ -->
    <div class="text-center p-8 bg-white bg-opacity-90 rounded-2xl shadow-xl w-full max-w-xl z-10 text-gray-800">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">ようこそ SleepTracker へ</h1>
        <p class="text-lg mb-8 leading-relaxed">
            SleepTracker は、毎日の睡眠時間や就寝・起床の記録を簡単に行えるウェブアプリです。<br>
            グラフでの可視化や、カレンダーでの記録確認も可能です。<br>
            睡眠習慣の見直しに役立てましょう！
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('login') }}"
               class="bg-blue-500 text-white px-6 py-1 rounded-lg hover:bg-blue-600 transition">
                ログイン
            </a>
            <span class="mx-2 text-gray-500">|</span>
            <a href="{{ route('register') }}"
               class="bg-blue-500 text-white px-6 py-1 rounded-lg hover:bg-blue-600 transition">
                新規登録
            </a>
        </div>
    </div>
</body>
</html>
