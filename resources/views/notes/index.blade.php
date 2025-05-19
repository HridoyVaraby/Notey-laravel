<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notes') }}
            </h2>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Create Note') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <div class="flex space-x-4">
                        <a href="{{ route('notes.index', ['filter' => 'all']) }}" class="px-4 py-2 rounded-md {{ $filter === 'all' ? 'bg-gray-200' : 'bg-white' }}">
                            {{ __('All Notes') }}
                        </a>
                        <a href="{{ route('notes.index', ['filter' => 'important']) }}" class="px-4 py-2 rounded-md {{ $filter === 'important' ? 'bg-gray-200' : 'bg-white' }}">
                            {{ __('Important') }}
                        </a>
                        <a href="{{ route('notes.index', ['filter' => 'bookmarked']) }}" class="px-4 py-2 rounded-md {{ $filter === 'bookmarked' ? 'bg-gray-200' : 'bg-white' }}">
                            {{ __('Bookmarked') }}
                        </a>
                    </div>
                </div>

                @if ($notes->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">{{ __('No notes found. Create your first note!') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($notes as $note)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 ease-in-out bg-{{ $note->color }}-50">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold">
                                            <a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a>
                                        </h3>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('notes.toggle-important', $note) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-gray-400 hover:text-yellow-500 {{ $note->is_important ? 'text-yellow-500' : '' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('notes.toggle-bookmarked', $note) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-gray-400 hover:text-blue-500 {{ $note->is_bookmarked ? 'text-blue-500' : '' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <a href="{{ route('notes.show', $note) }}" class="block"><p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($note->content, 150) }}</p></a>
                                    <div class="flex justify-between items-center text-sm text-gray-500">
                                        <span>{{ $note->created_at->diffForHumans() }}</span>
                                        @if ($note->attachments->count() > 0)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $note->attachments->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 border-t flex justify-end space-x-2">
                                    <a href="{{ route('notes.edit', $note) }}" class="text-sm text-blue-600 hover:text-blue-800">{{ __('Edit') }}</a>
                                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this note?')">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>