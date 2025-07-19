<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            月別 睡眠記録可視化
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 年月選択 --}}
            <div class="bg-white p-6 shadow rounded-lg">
                <form method="POST" action="{{ route('pie_chart.filter') }}"
                        class="flex flex-wrap sm:flex-nowrap items-center justify-center gap-4">
                    @csrf

                    <div class="flex items-center space-x-2">
                        <label for="year" class="text-gray-700 font-medium">年：</label>
                        <select name="year" id="year"
                                class="border border-gray-300 rounded px-5 py-1 pr-8 focus:ring focus:ring-blue-200">
                            @for ($y = date('Y'); $y >= 2022; $y--)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <label for="month" class="text-gray-700 font-medium">月：</label>
                        <select name="month" id="month"
                                class="border border-gray-300 rounded px-5 py-1 pr-8 focus:ring focus:ring-blue-200">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ $m }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                        表示
                    </button>
                </form>
            </div>



            {{-- カテゴリ円グラフ --}}
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-bold mb-4">{{ $year }}年{{ $month }}月：睡眠時間カテゴリ別</h3>
                <canvas id="pieChart" height="120"></canvas>
            </div>

            {{-- 散布図 --}}
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-bold mb-4">就寝 vs 起床時間（散布図）</h3>
                <canvas id="scatterChart" height="150"></canvas>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}">
                    <x-primary-button class="bg-black hover:bg-gray-800 text-white">ダッシュボードに戻る</x-primary-button>
                </a>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    data: {!! json_encode($values) !!},
                    backgroundColor: ['#f87171', '#facc15', '#34d399', '#60a5fa', '#a78bfa'],
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });

        new Chart(document.getElementById('scatterChart').getContext('2d'), {
            type: 'scatter',
            data: {
                datasets: [{
                    label: '就寝 vs 起床時間',
                    data: {!! json_encode($scatterPoints) !!},
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                scales: {
                    x: {
                        title: { display: true, text: '起床時間（時）' },
                        min: 5,
                        max: 11,
                        ticks: { callback: val => `${val}時` }
                    },
                    y: {
                        title: { display: true, text: '就寝時間（時）' },
                        min: 19,
                        max: 27,
                        ticks: { callback: val => val <= 24 ? `${val}時` : `${val - 24}時` }
                    }
                }
            }
        });
    </script>
</x-app-layout>