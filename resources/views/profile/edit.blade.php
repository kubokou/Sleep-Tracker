<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- 睡眠時間 -->
            {{-- 睡眠時間フォーム --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="POST" action="{{ route('profile.sleep.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="sleep_time" class="block text-sm font-medium text-gray-700">睡眠時間（例: 23:00）</label>
                            <input type="time" name="sleep_time" id="sleep_time"
                                   value="{{ old('sleep_time', auth()->user()->sleep_time) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('sleep_time')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-primary-button>{{ __('保存') }}</x-primary-button>
                        @if (session('status') === 'sleep-updated')
                            <p class="mt-2 text-sm text-green-600">睡眠時間を保存しました！</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
