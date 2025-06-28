<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- グラフ表示 --}}
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">最近の睡眠時間グラフ</h3>
                <canvas id="sleepChart" height="100"></canvas>
            </div>

            {{-- 睡眠記録フォーム --}}
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">睡眠記録の登録</h3>
                <form method="POST" action="{{ route('sleep.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        @error('date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="sleep_time" class="block text-sm font-medium text-gray-700">就寝時間</label>
                        <input type="time" name="sleep_time" id="sleep_time" value="{{ old('sleep_time') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        @error('sleep_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="wake_time" class="block text-sm font-medium text-gray-700">起床時間</label>
                        <input type="time" name="wake_time" id="wake_time" value="{{ old('wake_time') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        @error('wake_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="duration" class="block text-sm font-medium text-gray-700">睡眠時間（時間）</label>
                        <input type="number" step="0.1" name="duration" id="duration" value="{{ old('duration') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        @error('duration') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="memo" class="block text-sm font-medium text-gray-700">メモ（任意）</label>
                        <textarea name="memo" id="memo"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('memo') }}</textarea>
                        @error('memo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <x-primary-button>保存</x-primary-button>
                </form>
            </div>
        </div>
    </div>

    {{-- カレンダーボタン --}}
    <div class="flex justify-center">
        <a href="{{ route('calendar') }}">
            <x-primary-button>カレンダー</x-primary-button>
        </a>
    </div>


    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Chart描画スクリプト --}}
    <script>
        const ctx = document.getElementById('sleepChart').getContext('2d');

        const sleepChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($records->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('m/d'))),
                datasets: [{
                    label: '睡眠時間（時間）',
                    data: @json($records->pluck('duration')),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: '時間'
                        },
                        suggestedMax: 10
                    }
                }
            }
        });
    </script>
</x-app-layout>
