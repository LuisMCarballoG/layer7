<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-start items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Registrar Producto') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        <div class="w-3/4 mx-auto">
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Nombre')" />
                                <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Descripción')" />
                                <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-300">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="quantity" :value="__('Cantidad')" />
                                <x-text-input id="quantity" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="number" name="quantity" :value="old('quantity')" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="cost" :value="__('Costo')" />
                                <x-text-input id="cost" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="number" step="0.01" name="cost" :value="old('cost')" required />
                                <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                            </div>

                        </div>
                        <div class="flex items-center justify-between pt-6">
                            <x-nav-link class="mr-4" href="{{ route('products.index') }}">
                                {{ __('Cancelar') }}
                            </x-nav-link>
                            <x-primary-button>
                                {{ __('Crear Producto') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
