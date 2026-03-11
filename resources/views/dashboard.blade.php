<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h3>
                    <p class="text-blue-100">Selamat datang di katalog produk kami</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Produk</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Comments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Komentar Saya</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $userCommentsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Action -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Jelajahi Produk</p>
                                <p class="text-lg font-semibold text-gray-900">Lihat Katalog</p>
                            </div>
                            <a href="{{ route('user.products.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
                                Lihat →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Products -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terbaru</h3>
                    
                    @if($latestProducts->count() > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2">
                            @foreach($latestProducts as $product)
                                <a href="{{ route('user.products.show', $product->id) }}" class="bg-white border border-gray-100 rounded overflow-hidden hover:shadow-md transition-shadow block">
                                    @if($product->gambar)
                                        <div class="aspect-square overflow-hidden">
                                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="aspect-square bg-gray-50 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="px-2 py-1.5">
                                        <h4 class="text-xs text-gray-800 line-clamp-2 leading-tight" style="min-height: 2rem;">{{ $product->nama_produk }}</h4>
                                        <div class="mt-1">
                                            <span class="text-orange-600 font-bold text-sm">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mt-0.5 text-[10px] text-gray-400">
                                            Stok: {{ $product->stok }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada produk tersedia.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Comments -->
            @if($recentComments->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Komentar Terbaru Saya</h3>
                        <div class="space-y-4">
                            @foreach($recentComments as $comment)
                                <div class="border-l-4 border-blue-500 bg-gray-50 p-4 rounded">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                Pada produk: <a href="{{ route('user.products.show', $comment->produk_id) }}" class="text-blue-600 hover:underline">{{ $comment->produk->nama_produk }}</a>
                                            </p>
                                            <p class="text-gray-700 mt-2">{{ $comment->comment }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
