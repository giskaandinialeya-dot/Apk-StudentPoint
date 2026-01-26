@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tambah Prestasi</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('guru.prestasi.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Siswa Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Pilih Siswa <span class="text-red-500">*</span>
                    </label>
                    <select name="siswa_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non-Akademik</option>
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
                    <input type="number" name="poin" min="1" max="100" value="{{ old('poin') }}" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-sm mt-1">Masukkan poin antara 1-100</p>
                    @error('poin')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" 
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
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bukti File -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Bukti Dokumen (Opsional)
                    </label>
                    <input type="file" name="bukti_file" accept=".jpg,.jpeg,.png,.pdf" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-sm mt-1">Format: JPEG, PNG, PDF (Max 2MB)</p>
                    @error('bukti_file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg">
                        Simpan
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
