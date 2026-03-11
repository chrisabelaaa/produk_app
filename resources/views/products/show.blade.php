<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Product Detail -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Product Image -->
                        <div class="md:col-span-3">
                            @if($product->gambar)
                                <div class="aspect-square overflow-hidden rounded border border-gray-200 max-w-[200px] mx-auto">
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="aspect-square max-w-[200px] mx-auto bg-gray-50 rounded border border-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Information -->
                        <div class="md:col-span-9">
                            <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $product->nama_produk }}</h1>
                            
                            <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                <span class="text-2xl font-bold text-orange-600">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>

                            <div class="mb-4 pb-3 border-b border-gray-200">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600">Stok:</span>
                                    <span class="text-sm font-semibold {{ $product->stok > 0 ? 'text-gray-800' : 'text-red-600' }}">
                                        {{ $product->stok > 0 ? "{$product->stok} unit tersedia" : 'Stok habis' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $product->deskripsi }}</p>
                            </div>

                            <!-- Admin Actions -->
                            @if(auth()->user()->role === 'admin')
                                <div class="flex space-x-4 mt-6">
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                        Edit Produk
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                            Hapus Produk
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors inline-block">
                                    ← Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Komentar ({{ $product->comments->count() }})</h3>

                    <!-- Add Comment Form -->
                    <div class="mb-8 bg-blue-50 p-4 rounded-lg">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">
                            
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Tambah Komentar</label>
                                <textarea 
                                    name="comment" 
                                    id="comment" 
                                    rows="4" 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    placeholder="Tulis komentar Anda..."
                                    required
                                ></textarea>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                Kirim Komentar
                            </button>
                        </form>
                    </div>

                    <!-- Comments List -->
                    @if($product->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($product->comments->sortByDesc('created_at') as $comment)
                                <div class="border border-gray-200 rounded-lg p-4 {{ $comment->user_id === auth()->id() ? 'bg-blue-50 border-blue-200' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $comment->user->name }}
                                                        @if($comment->user_id === auth()->id())
                                                            <span class="text-xs text-blue-600 font-normal">(Anda)</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 ml-13">{{ $comment->comment }}</p>
                                        </div>

                                        @if($comment->user_id === auth()->id() || auth()->user()->role === 'admin')
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="ml-4" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>