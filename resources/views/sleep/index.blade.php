<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('睡眠記録') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- グラフ --}}
        <canvas id="sleepChart" height="100"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('sleepChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($records->pluck('date')),
                    datasets: [{
                        label: '睡眠時間（時間）',
                        data: @json($records->pluck('duration')),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.2,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 10
                        }
                    }
                }
            });
        </script>

        {{-- 記録フォーム --}}
        <div class="bg-white p-6 shadow rounded">
            <form method="POST" action="{{ route('sleep.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="date" class="block">日付</label>
                    <input type="date" name="date" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="sleep_time" class="block">就寝時間</label>
                    <input type="time" name="sleep_time" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="wake_time" class="block">起床時間</label>
                    <input type="time" name="wake_time" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="duration" class="block">睡眠時間（例: 7.5）</label>
                    <input type="number" step="0.1" name="duration" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="memo" class="block">メモ</label>
                    <textarea name="memo" class="form-textarea w-full"></textarea>
                </div>

                <x-primary-button>保存</x-primary-button>
            </form>
        </div>

        {{-- カレンダーボタン --}}
        <div class="mt-6 flex justify-center">
            <a href="{{ route('calendar') }}">
                <x-primary-button>カレンダー</x-primary-button>
            </a>
        </div>

    </div>
</x-app-layout>
