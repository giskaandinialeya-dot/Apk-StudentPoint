@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Edit Prestasi</h1>
                <p class="text-gray-600"><i class="fas fa-edit"></i> Ubah data prestasi siswa</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto" data-aos="fade-up">
        <form action="{{ route('guru.prestasi.update', $prestasi) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Siswa Selection -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-user text-green-600 mr-2"></i>Siswa
                </label>
                <input type="text" disabled value="{{ $prestasi->siswa->nama_lengkap }} ({{ $prestasi->siswa->nis }})" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                <input type="hidden" name="siswa_id" value="{{ $prestasi->siswa_id }}">
            </div>

            <!-- Nama Prestasi -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-trophy text-green-600 mr-2"></i>Nama Prestasi
                </label>
                <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('nama_prestasi')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Poin -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-star text-green-600 mr-2"></i>Poin Prestasi
                </label>
                <input type="number" name="poin" min="1" max="100" value="{{ old('poin', $prestasi->poin) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('poin')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-calendar text-green-600 mr-2"></i>Tanggal Prestasi
                </label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Tingkat -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-flag text-green-600 mr-2"></i>Tingkat Prestasi
                </label>
                <select name="tingkat" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="kelas" {{ $prestasi->tingkat === 'kelas' ? 'selected' : '' }}>Tingkat Kelas</option>
                    <option value="sekolah" {{ $prestasi->tingkat === 'sekolah' ? 'selected' : '' }}>Tingkat Sekolah</option>
                    <option value="regional" {{ $prestasi->tingkat === 'regional' ? 'selected' : '' }}>Tingkat Regional</option>
                    <option value="nasional" {{ $prestasi->tingkat === 'nasional' ? 'selected' : '' }}>Tingkat Nasional</option>
                </select>
                @error('tingkat')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti File -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-file-upload text-green-600 mr-2"></i>Bukti / Sertifikat (Opsional)
                </label>
                @if($prestasi->bukti_file)
                    <p class="text-gray-600 text-sm mb-2"><i class="fas fa-check-circle text-green-600"></i> File sudah tersimpan: {{ $prestasi->bukti_file }}</p>
                @endif
                <input type="file" name="bukti_file" accept="image/*,application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG, PDF (Max 5MB)</p>
                @error('bukti_file')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-info-circle text-green-600 mr-2"></i>Status
                </label>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="aktif" {{ $prestasi->status === 'aktif' ? 'checked' : '' }} class="w-4 h-4 text-green-600">
                        <span class="text-gray-900 font-semibold">Aktif</span>
                        <span class="text-gray-500 text-sm">(Prestasi valid dan berlaku)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="diverifikasi" {{ $prestasi->status === 'diverifikasi' ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                        <span class="text-gray-900 font-semibold">Diverifikasi</span>
                        <span class="text-gray-500 text-sm">(Menunggu verifikasi)</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('guru.prestasi.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
