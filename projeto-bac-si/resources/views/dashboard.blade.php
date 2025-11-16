<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2> -->
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('message'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Nossos Produtos
                </h2>
        
                <div class="mt-6 space-y-4">
                    @foreach ($products as $product)
                        <div class="p-4 bg-gray-100 dark:bg-gray-900 shadow rounded-lg flex justify-between items-center">
                            <div>
                                <div class="font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                            </div>
                            
                            <form action="{{ url('/cart/add') }}" method="POST">
                                @csrf <input type="hidden" name="product_id" value="{{ $product->id }}">
        
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Adicionar ao Carrinho
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
