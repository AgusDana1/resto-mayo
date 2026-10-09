@extends('layouts.admin')

@section('title', 'Kategori Menu - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200">
                    Katalog Kuliner
                </span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-400 font-medium">Resto Mayo Master Data</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-1 font-poppins">
                Manajemen Kategori
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Atur dan klasifikasikan menu makanan serta minuman untuk mempermudah pemesanan pelanggan.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.create') }}" 
               class="inline-flex items-center space-x-2 px-5 py-3 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 group">
                <svg class="w-5 h-5 text-resto-gold-200 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Kategori Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total Kategori -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-red-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Kategori</p>
                    <h3 class="text-3xl font-bold text-resto-red-900 mt-1 font-poppins">{{ $categories->total() }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Terdaftar dalam sistem resto</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Kategori Aktif Berisi Produk -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-gold-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-resto-gold-800">Dengan Menu Produk</p>
                    <h3 class="text-3xl font-bold text-resto-gold-700 mt-1 font-poppins">
                        {{ $categories->filter(fn($c) => $c->products_count > 0)->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Kategori yang siap disajikan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Nuansa & Tema Resto Mayo -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Aturan Relasi</p>
                    <h3 class="text-base font-bold text-resto-red-900 mt-1 font-poppins">Integritas Terjaga</h3>
                    <p class="text-xs text-gray-500 mt-1">Restriksi otomatis jika kategori memiliki produk aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari nama kategori..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all">
            </div>

            <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                <button type="submit" 
                        class="px-4 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                    Cari Kategori
                </button>
                @if(!empty($search))
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Category Data Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nama Kategori</th>
                            <th class="py-4 px-6 text-center">Total Produk</th>
                            <th class="py-4 px-6">Tanggal Dibuat</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($categories as $index => $category)
                            <tr class="hover:bg-resto-red-50/30 transition-colors group">
                                <!-- Nomor -->
                                <td class="py-4 px-6 text-center font-medium text-gray-400">
                                    {{ $categories->firstItem() + $index }}
                                </td>

                                <!-- Nama Kategori -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-resto-red-100/70 text-resto-red-800 flex items-center justify-center font-bold text-base shadow-xs border border-resto-red-200/50">
                                            {{ strtoupper(substr($category->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="font-semibold text-gray-800 hover:text-resto-red-800 transition-colors font-poppins">
                                                {{ $category->name }}
                                            </a>
                                            <p class="text-xs text-gray-400">ID: #CAT-{{ str_pad($category->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Total Produk -->
                                <td class="py-4 px-6 text-center">
                                    @if($category->products_count > 0)
                                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-300/80 shadow-xs">
                                            <svg class="w-3.5 h-3.5 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                            </svg>
                                            <span>{{ $category->products_count }} Produk</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">
                                            Belum Ada Produk
                                        </span>
                                    @endif
                                </td>

                                <!-- Tanggal Dibuat -->
                                <td class="py-4 px-6 text-gray-500 text-xs">
                                    <div>{{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}</div>
                                    <div class="text-gray-400 text-[11px]">{{ $category->created_at ? $category->created_at->format('H:i') . ' WIB' : '' }}</div>
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Lihat Detail -->
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="p-2 rounded-lg text-gray-500 hover:text-resto-red-800 hover:bg-resto-red-50 border border-transparent hover:border-resto-red-200 transition-colors"
                                           title="Lihat Detail & Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="p-2 rounded-lg text-gray-500 hover:text-resto-gold-800 hover:bg-resto-gold-50 border border-transparent hover:border-resto-gold-200 transition-colors"
                                           title="Ubah Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>

                                        <!-- Hapus (Modal Trigger) -->
                                        <button type="button" 
                                                onclick="openDeleteModal('{{ $category->id }}', '{{ addslashes($category->name) }}', {{ $category->products_count }})"
                                                class="p-2 rounded-lg text-gray-400 hover:text-resto-red-700 hover:bg-resto-red-50 border border-transparent hover:border-resto-red-200 transition-colors"
                                                title="Hapus Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                {{ $categories->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-resto-red-50 text-resto-red-800 flex items-center justify-center mb-4 border border-resto-red-100">
                    <svg class="w-10 h-10 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-resto-red-900 font-poppins">Belum Ada Kategori Ditemukan</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                    @if(!empty($search))
                        Tidak ada kategori yang cocok dengan kata kunci "{{ $search }}". Silakan coba kata kunci lain.
                    @else
                        Mulai bangun menu Resto Mayo dengan menambahkan kategori hidangan pertama Anda.
                    @endif
                </p>
                <div class="mt-6">
                    @if(!empty($search))
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                            Lihat Semua Kategori
                        </a>
                    @else
                        <a href="{{ route('admin.categories.create') }}" 
                           class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah Kategori Sekarang</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation / Warning Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>

        <!-- Modal Card -->
        <div class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl border border-gray-100">
            
            <!-- Warning State: If category has products -->
            <div id="modalWarningHasProducts" class="hidden">
                <div class="w-12 h-12 mx-auto rounded-full bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-center text-resto-red-900 font-poppins">Kategori Tidak Dapat Dihapus</h3>
                <p class="mt-2 text-sm text-center text-gray-600">
                    Kategori <span id="categoryNameWarning" class="font-bold text-resto-red-800"></span> saat ini masih menaungi <span id="productsCountWarning" class="font-bold text-resto-gold-700"></span> produk.
                </p>
                <div class="mt-4 p-3 rounded-xl bg-resto-gold-50 border border-resto-gold-200 text-xs text-resto-gold-900 leading-relaxed">
                    <strong>Pemberitahuan Sistem:</strong> Database Resto Mayo menerapkan proteksi <em>restrictOnDelete</em>. Anda wajib memindahkan atau menghapus semua produk di dalam kategori ini sebelum menghapus kategorinya.
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                        Mengerti & Tutup
                    </button>
                </div>
            </div>

            <!-- Can Delete State: Category has 0 products -->
            <div id="modalCanDelete" class="hidden">
                <div class="w-12 h-12 mx-auto rounded-full bg-resto-red-100 text-resto-red-800 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-resto-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-center text-resto-red-900 font-poppins">Konfirmasi Hapus Kategori</h3>
                <p class="mt-2 text-sm text-center text-gray-600">
                    Apakah Anda yakin ingin menghapus kategori <span id="categoryNameConfirm" class="font-bold text-resto-red-800"></span>?
                </p>
                <p class="mt-1 text-xs text-center text-gray-400">
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" 
                            class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                        Ya, Hapus Kategori
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(categoryId, categoryName, productsCount) {
        const modal = document.getElementById('deleteModal');
        const modalWarning = document.getElementById('modalWarningHasProducts');
        const modalCanDelete = document.getElementById('modalCanDelete');
        const form = document.getElementById('deleteForm');

        if (productsCount > 0) {
            modalWarning.classList.remove('hidden');
            modalCanDelete.classList.add('hidden');
            document.getElementById('categoryNameWarning').innerText = '"' + categoryName + '"';
            document.getElementById('productsCountWarning').innerText = productsCount;
        } else {
            modalWarning.classList.add('hidden');
            modalCanDelete.classList.remove('hidden');
            document.getElementById('categoryNameConfirm').innerText = '"' + categoryName + '"';
            form.action = "{{ url('admin/categories') }}/" + categoryId;
        }

        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endpush
@endsection

