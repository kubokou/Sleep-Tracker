<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $date }} の睡眠記録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow sm:rounded-lg p-6">
            @if($records->isEmpty())
                <p>この日の記録はありません。</p>
            @else
                @foreach ($records as $record)
                    @php
                        $sleep = \Carbon\Carbon::parse($record->sleep_time)->format('H:i');
                        $wake = \Carbon\Carbon::parse($record->wake_time)->format('H:i');
                        $hours = floor($record->duration);
                        $minutes = round(($record->duration - $hours) * 60);
                    @endphp
                    <div class="mb-4 border-b pb-4">
                        <p><strong>就寝時間:</strong> {{ $sleep }}</p>
                        <p><strong>起床時間:</strong> {{ $wake }}</p>
                        <p><strong>睡眠時間:</strong> {{ $hours }}時間{{ $minutes }}分</p>
                        <p><strong>メモ:</strong> {{ $record->memo ?? '（なし）' }}</p>
                    </div>
                @endforeach
            @endif

            <div class="mt-6">
                <a href="{{ route('calendar') }}" class="text-blue-500 hover:underline">← カレンダーに戻る</a>
            </div>
        </div>
    </div>
</x-app-layout>
