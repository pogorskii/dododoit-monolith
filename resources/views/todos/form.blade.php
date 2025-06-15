<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($todo) && $todo->exists ? 'Edit Todo' : 'Create Todo' }}
        </h2>
    </x-slot>

    @php
        $isEdit = isset($todo) && $todo->exists;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-center">
                        <div class="w-8/12 p-6 rounded-lg">
                            <form
                                    action="{{ $isEdit ? route('todos.update', $todo->id) : route('todos.store') }}"
                                    method="POST"
                            >
                                @csrf
                                @method($isEdit ? 'PUT' : 'POST')
                                <div class="mb-4">
                                    <label for="title" class="sr-only">Title</label>
                                    <input type="text" name="title" id="title"
                                           class="bg-gray-900 border-2 w-full p-4 rounded-lg @error('title') border-red-500 @enderror"
                                           value="{{ old('title', $todo->title ?? '') }}"
                                           placeholder="Enter todo title">
                                    @error('title')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="sr-only">Description</label>
                                    <textarea name="description" id="description"
                                              class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('description') border-red-500 @enderror">{{ old('description',$todo->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">
                                        {{ $isEdit ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
