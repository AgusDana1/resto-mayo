@extends('layouts.admin')

@section('title', 'Ubah Produk - ' . $product->name . ' - Resto Mayo')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Breadcrumb & Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" 
           class="inline-flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-resto-red-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Manajemen Produk</span>
        </a>

        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200">
            Edit Data Menu #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
        </span>
    </div>

    <!-- Header Section -->
    <div class="border-b border-gray-100 pb-5">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-resto-red-900 font-poppins">
            Ubah Produk Menu
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui data hidangan <span class="font-semibold text-resto-red-800">"{{ $product->name }}"</span>, harga, atau ketersediaan stok.
        </p>
    </div>

    <!-- Main Grid: Form (Left) & Live Preview (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

        <!-- Form Column (2 Cols on Desktop) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('admin.products.update', $product) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Kategori Menu -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1.5 font-poppins">
                        Kategori Menu <span class="text-resto-red-800">*</span>
                    </label>
                    <div class="relative">
                        <select name="category_id" 
                                id="category_id" 
                                required
                                onchange="updatePreviewCategory(this)"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('category_id') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all bg-white">
                            <option value="" disabled>-- Pilih Kategori Hidangan --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        data-name="{{ $category->name }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <p class="mt-1.5 text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Nama Produk Menu -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5 font-poppins">
                        Nama Produk Menu <span class="text-resto-red-800">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $product->name) }}" 
                           required 
                           maxlength="255"
                           placeholder="Contoh: Risoles Mayonise Keju Spesial" 
                           oninput="updatePreviewName(this.value)"
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all placeholder-gray-400">
                    @error('name')
                        <p class="mt-1.5 text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Harga Produk (IDR) -->
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5 font-poppins">
                        Harga Jual (Rp) <span class="text-resto-red-800">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold text-sm">
                            Rp
                        </div>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', (int)$product->price) }}" 
                               required 
                               min="0" 
                               step="500"
                               placeholder="18000" 
                               oninput="updatePreviewPrice(this.value)"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('price') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all placeholder-gray-400 font-mono">
                    </div>
                    <div class="flex items-center justify-between mt-1.5">
                        <p class="text-xs text-gray-400">
                            Masukkan nominal angka tanpa titik atau koma.
                        </p>
                        <span id="formattedPriceText" class="text-xs font-bold text-resto-gold-800 font-poppins">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi Hidangan -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5 font-poppins">
                        Deskripsi Hidangan
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="3" 
                              placeholder="Jelaskan cita rasa, bumbu rahasia, atau keistimewaan menu ini..."
                              oninput="updatePreviewDesc(this.value)"
                              class="w-full px-4 py-3 rounded-xl border {{ $errors->has('description') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all placeholder-gray-400 leading-relaxed">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Foto & Gambar Produk Section -->
                <div class="space-y-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-semibold text-gray-700 font-poppins">
                            Foto / Gambar Produk
                        </label>
                        <span class="text-xs text-gray-400">Pilih Upload File Baru atau Masukkan URL</span>
                    </div>

                    @php
                        $currentImageUrl = $product->image 
                            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) 
                            : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80';
                    @endphp

                    <!-- Current Image Preview Banner -->
                    @if($product->image)
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 flex items-center space-x-3">
                            <img src="{{ $currentImageUrl }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-bold text-gray-700 block truncate">Gambar Saat Ini Aktif</span>
                                <span class="text-[11px] text-gray-400 block truncate">Biarkan kosong jika tidak ingin mengubah gambar.</span>
                            </div>
                        </div>
                    @endif

                    <!-- Upload File Input -->
                    <div class="border-2 border-dashed border-gray-200 hover:border-resto-gold-500 rounded-2xl p-5 text-center transition-colors bg-gray-50/50 group">
                        <input type="file" 
                               name="image" 
                               id="imageFileInput" 
                               accept="image/png,image/jpeg,image/webp"
                               onchange="handleFileUpload(this)"
                               class="hidden">
                        
                        <label for="imageFileInput" class="cursor-pointer flex flex-col items-center space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-resto-red-800 group-hover:underline">
                                Unggah foto baru dari komputer / ponsel
                            </span>
                            <span class="text-[11px] text-gray-400">
                                Format: JPG, PNG, WEBP (Maksimal 2MB)
                            </span>
                        </label>
                        <p id="uploadedFileName" class="text-xs font-bold text-emerald-700 mt-2 hidden"></p>
                    </div>
                    @error('image')
                        <p class="text-xs text-resto-red-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror

                    <!-- Divider OR -->
                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink mx-4 text-xs font-bold uppercase text-gray-400">Atau Ganti Link URL</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <!-- Direct Image URL Input -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <input type="url" 
                                   name="image_url" 
                                   id="imageUrlInput" 
                                   value="{{ old('image_url', str_starts_with($product->image ?? '', 'http') ? $product->image : '') }}" 
                                   placeholder="https://images.unsplash.com/photo-..." 
                                   oninput="handleUrlInput(this.value)"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('image_url') ? 'border-resto-red-600 focus:ring-resto-red-600' : 'border-gray-200 focus:ring-resto-red-700' }} text-xs focus:outline-none focus:ring-2 focus:border-transparent transition-all placeholder-gray-400">
                        </div>
                        @error('image_url')
                            <p class="mt-1 text-xs text-resto-red-700 flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Status Ketersediaan (is_available) -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-poppins">
                        Status Ketersediaan
                    </label>
                    <div class="flex items-center space-x-3 p-4 rounded-xl bg-gray-50 border border-gray-200">
                        <input type="checkbox" 
                               name="is_available" 
                               id="is_available" 
                               value="1" 
                               {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}
                               onchange="updatePreviewStatus(this.checked)"
                               class="w-5 h-5 rounded text-resto-red-800 focus:ring-resto-red-700 border-gray-300 transition-colors cursor-pointer">
                        <label for="is_available" class="cursor-pointer select-none">
                            <span class="block text-sm font-bold text-gray-800">
                                Menu Tersedia & Siap Dipesan
                            </span>
                            <span class="block text-xs text-gray-500">
                                Jika dinonaktifkan, menu akan ditandai habis dan tidak dapat dipesan oleh pelanggan.
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50">
                        <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Perbarui Produk Menu</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- Right Column: Live Mockup Preview & Info (1 Col) -->
        <div class="space-y-6">

            <!-- Live Card Preview (Realtime Display) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sticky top-28">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-resto-gold-800 font-poppins">
                        Pratinjau Kartu Menu
                    </h3>
                    <span id="previewStatusBadge" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($product->is_available ?? true) ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ ($product->is_available ?? true) ? 'Tersedia' : 'Habis / Nonaktif' }}
                    </span>
                </div>

                <!-- Customer Card Mockup -->
                <div class="mt-4 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col group">
                    <!-- Photo Mockup Container -->
                    <div class="h-44 w-full bg-gray-100 relative overflow-hidden">
                        <img id="previewImage" 
                             src="{{ $currentImageUrl }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <!-- Details Mockup Container -->
                    <div class="p-4 flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center justify-between">
                                <span id="previewCategory" class="text-[10px] font-bold text-resto-gold-800 uppercase tracking-wider">
                                    {{ $product->category->name ?? 'Kategori Menu' }}
                                </span>
                            </div>
                            <h4 id="previewTitle" class="font-bold text-gray-900 text-base mt-1 font-poppins line-clamp-1">
                                {{ $product->name }}
                            </h4>
                            <p id="previewDesc" class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                {{ $product->description ?? 'Deskripsi hidangan belum ditambahkan.' }}
                            </p>
                        </div>

                        <!-- Price & Action Mockup -->
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                                <span id="previewPrice" class="text-sm font-extrabold text-resto-red-900 font-poppins">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <span class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl bg-resto-red-800 text-white text-xs font-semibold shadow-xs">
                                <svg class="w-3.5 h-3.5 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Pesan</span>
                            </span>
                        </div>
                    </div>
                </div>

                <p class="text-[11px] text-gray-400 mt-3 text-center">
                    Visualisasi kartu menu di etalase pelanggan saat melakukan pemesanan.
                </p>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    // Live Preview State
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');
    const previewPrice = document.getElementById('previewPrice');
    const previewCategory = document.getElementById('previewCategory');
    const previewImage = document.getElementById('previewImage');
    const previewStatusBadge = document.getElementById('previewStatusBadge');
    const formattedPriceText = document.getElementById('formattedPriceText');

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function updatePreviewName(val) {
        const trimmed = val.trim();
        previewTitle.innerText = trimmed.length > 0 ? trimmed : 'Nama Hidangan';
    }

    function updatePreviewDesc(val) {
        const trimmed = val.trim();
        previewDesc.innerText = trimmed.length > 0 
            ? trimmed 
            : 'Deskripsi hidangan belum ditambahkan.';
    }

    function updatePreviewPrice(val) {
        const num = parseFloat(val) || 0;
        const formatted = formatRupiah(num);
        previewPrice.innerText = formatted;
        formattedPriceText.innerText = formatted;
    }

    function updatePreviewCategory(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const categoryName = selectedOption.getAttribute('data-name');
        if (categoryName) {
            previewCategory.innerText = categoryName;
        }
    }

    function updatePreviewStatus(isChecked) {
        if (isChecked) {
            previewStatusBadge.innerText = 'Tersedia';
            previewStatusBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800';
        } else {
            previewStatusBadge.innerText = 'Habis / Nonaktif';
            previewStatusBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600';
        }
    }

    function handleFileUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            document.getElementById('uploadedFileName').innerText = '✓ Terpilih: ' + file.name;
            document.getElementById('uploadedFileName').classList.remove('hidden');

            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }

    function handleUrlInput(url) {
        const trimmed = url.trim();
        if (trimmed.length > 10 && (trimmed.startsWith('http://') || trimmed.startsWith('https://'))) {
            previewImage.src = trimmed;
        }
    }
</script>
@endpush
@endsection

