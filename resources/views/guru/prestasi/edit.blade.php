@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Prestasi</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('guru.prestasi.update', $prestasi) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <!-- Siswa Info -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600">Siswa</p>
                    <p class="font-semibold text-gray-900">{{ $prestasi->siswa->nama_lengkap }}</p>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="akademik" @selected($prestasi->kategori === 'akademik')>Akademik</option>
                        <option value="non-akademik" @selected($prestasi->kategori === 'non-akademik')>Non-Akademik</option>
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poin -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Poin <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="poin" min="1" max="100" value="{{ old('poin', $prestasi->poin) }}" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('poin')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="4" maxlength="500" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bukti File -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Bukti Dokumen
                    </label>
                    @if($prestasi->bukti_file)
                        <div class="mb-2 p-3 bg-green-50 rounded border border-green-200">
                            <p class="text-sm text-gray-600">File saat ini:</p>
                            <a href="{{ asset($prestasi->bukti_file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                Lihat Dokumen
                            </a>
                        </div>
                    @endif
                    <input type="file" name="bukti_file" accept=".jpg,.jpeg,.png,.pdf" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-sm mt-1">Kosongi jika tidak ingin mengubah file</p>
                    @error('bukti_file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('guru.prestasi.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 rounded-lg text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
