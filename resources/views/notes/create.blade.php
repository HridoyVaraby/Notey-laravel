<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Color')" />
                        <div class="mt-2 flex space-x-4">
                            <div class="flex items-center">
                                <input type="radio" id="color-yellow" name="color" value="yellow" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                <label for="color-yellow" class="ml-2 block text-sm font-medium text-gray-700">
                                    <span class="inline-block w-4 h-4 bg-yellow-200 rounded-full mr-1"></span>
                                    {{ __('Yellow') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="color-light-blue" name="color" value="light-blue" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="color-light-blue" class="ml-2 block text-sm font-medium text-gray-700">
                                    <span class="inline-block w-4 h-4 bg-blue-200 rounded-full mr-1"></span>
                                    {{ __('Light Blue') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="color-beige" name="color" value="beige" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="color-beige" class="ml-2 block text-sm font-medium text-gray-700">
                                    <span class="inline-block w-4 h-4 bg-amber-100 rounded-full mr-1"></span>
                                    {{ __('Beige') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_important" name="is_important" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_important" class="ml-2 block text-sm font-medium text-gray-700">
                                    {{ __('Mark as Important') }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_bookmarked" name="is_bookmarked" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_bookmarked" class="ml-2 block text-sm font-medium text-gray-700">
                                    {{ __('Bookmark') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="attachments" :value="__('Attachments')" />
                        <input type="file" id="attachments" name="attachments[]" multiple class="block mt-1 w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        " />
                        <p class="mt-1 text-sm text-gray-500">{{ __('You can upload multiple files (max 10MB each)') }}</p>
                        <x-input-error :messages="$errors->get('attachments')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('notes.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Create Note') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>