<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-start items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Información de Producto - ') . $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-3/4 mx-auto">
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" disabled readonly class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="text" name="name" :value="$product->name" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" disabled readonly name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-300">{{ $product->description }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" disabled readonly class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="number" name="quantity" :value="$product->quantity" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="cost" :value="__('Costo')" />
                            <x-text-input id="cost" disabled readonly class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-300" type="number" step="0.01" name="cost" :value="$product->cost" required />
                            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex items-center justify-between pt-6">
                        <x-nav-link class="mr-4" href="{{ route('products.index') }}">
                            {{ __('Regresar') }}
                        </x-nav-link>
                        @if($product->user_id == \Auth::user()->id)
                            <x-nav-link class="mr-4" href="{{ route('products.edit', $product->id) }}">
                                {{ __('Editar') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
