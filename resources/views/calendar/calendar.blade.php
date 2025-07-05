<!-- calendar.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カレンダーで睡眠記録を見る
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- カレンダー表示 -->
            <div id="calendar" class="bg-white rounded shadow p-6"></div>

            <!-- 新規追加モーダル -->
            <div id="modal-add" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg w-96">
                    <form method="POST" action="{{ route('create') }}">
                        @csrf
                        <input id="new-id" type="hidden" name="id" value="" />

                        <div class="mb-4">
                            <label for="event_title" class="block font-semibold">タイトル</label>
                            <input id="new-event_title" type="text" name="event_title" class="w-full border rounded p-2" required />
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block font-semibold">開始日</label>
                            <input id="new-start_date" type="date" name="start_date" class="w-full border rounded p-2" required />
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block font-semibold">終了日</label>
                            <input id="new-end_date" type="date" name="end_date" class="w-full border rounded p-2" required />
                        </div>

                        <div class="mb-4">
                            <label for="event_body" class="block font-semibold">内容</label>
                            <textarea id="new-event_body" name="event_body" rows="3" class="w-full border rounded p-2"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="event_color" class="block font-semibold">色</label>
                            <select id="new-event_color" name="event_color" class="w-full border rounded p-2">
                                <option value="blue" selected>青</option>
                                <option value="green">緑</option>
                                <option value="red">赤</option>
                            </select>
                        </div>

                        <div class="flex justify-between">
                            <button type="button" onclick="closeAddModal()" class="bg-gray-300 hover:bg-gray-400 text-black py-1 px-4 rounded">キャンセル</button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded">登録</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="flex justify-center mt-6">
                <a href="{{ route('dashboard') }}">
                    <x-primary-button class="bg-black hover:bg-gray-800 text-white">
                        ダッシュボードに戻る
                    </x-primary-button>
                </a>
            </div>

        </div>
        <script>
            window.data = {sleepRecords:@json($sleepRecords)};
        </script>
    </div>

     <!-- CSRF Token（fetch用）
    <meta name="csrf-token" content="{{ csrf_token() }}"> -->
</x-app-layout>
