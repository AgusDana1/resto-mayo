@extends('layouts.admin')

@section('title', 'Ubah Kategori - ' . $category->name . ' - Resto Mayo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-resto-red-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Daftar Kategori</span>
        </a>

        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200">
            Edit Data
        </span>
    </div>

    <!-- Header Section -->
    <div class="border-b border-gray-100 pb-5">
        <h1 class="text-2xl font-bold tracking-tight text-resto-red-900 font-poppins">
            Ubah Kategori Menu
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui nama atau identitas kategori <span class="font-semibold text-resto-red-800">"{{ $category->name }}"</span>.
        </p>
    </div>

    <!-- Main Card & Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Column (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Kategori Input -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5 font-poppins">
                        Nama Kategori <span class="text-resto-red-800">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $category->name) }}" 
                               required 
                               maxlength="255"
                               placeholder="Contoh: Aneka Steak & Grill" 
                               oninput="updatePreview(this.value)"
                               class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all placeholder-gray-400">
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-400">
                        Pastikan nama kategori tetap deskriptif dan mencerminkan kelompok menu di dalamnya.
                    </p>
                </div>

                <!-- Info Box: Dampak Perubahan -->
                <div class="p-4 rounded-xl bg-resto-gold-50/60 border border-resto-gold-200/80 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-resto-gold-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-xs text-gray-700 leading-relaxed">
                        Perubahan nama kategori ini akan langsung berdampak pada 
                        <strong class="text-resto-gold-800">{{ $category->products_count }} produk</strong> 
                        yang saat ini terdaftar di bawah kategori ini.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50">
                        <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Perbarui Kategori</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar / Details & Mockup (1 Col) -->
        <div class="space-y-6">

            <!-- Live Mockup Preview -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-resto-gold-800">
                        Pratinjau Hasil
                    </h3>
                    <span class="inline-block w-2 h-2 rounded-full bg-resto-gold-600"></span>
                </div>
                
                <div class="mt-4 p-4 rounded-xl bg-white border border-dashed border-gray-200 text-center">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center font-bold text-lg mb-2" id="previewInitial">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <h4 class="font-bold text-resto-red-900 text-base font-poppins" id="previewName">
                        {{ $category->name }}
                    </h4>
                    <div class="mt-2 inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200">
                        <span>{{ $category->products_count }} Menu Terdaftar</span>
                    </div>
                </div>
            </div>

            <!-- Metadata Info -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">
                    Informasi Catatan
                </h3>
                <dl class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-400">ID Kategori</dt>
                        <dd class="font-medium text-gray-700">#CAT-{{ str_pad($category->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-400">Dibuat</dt>
                        <dd class="font-medium text-gray-700">{{ $category->created_at ? $category->created_at->format('d M Y, H:i') : '-' }}</dd>
                    </div>
                    <div class="flex justify-between py-1">
                        <dt class="text-gray-400">Pembaruan Terakhir</dt>
                        <dd class="font-medium text-gray-700">{{ $category->updated_at ? $category->updated_at->format('d M Y, H:i') : '-' }}</dd>
                    </div>
                </dl>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function updatePreview(val) {
        const previewName = document.getElementById('previewName');
        const previewInitial = document.getElementById('previewInitial');
        const trimmed = val.trim();

        if (trimmed.length > 0) {
            previewName.innerText = trimmed;
            previewInitial.innerText = trimmed.charAt(0).toUpperCase();
        } else {
            previewName.innerText = 'Nama Kategori';
            previewInitial.innerText = 'K';
        }
    }
</script>
@endpush
@endsection

