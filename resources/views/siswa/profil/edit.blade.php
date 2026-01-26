@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Profil</h1>
                <a href="{{ route('siswa.profil.show') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('siswa.profil.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('nama_lengkap') border-red-500 @enderror"
                    />
                    @error('nama_lengkap')
                        <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jenis Kelamin
                    </label>
                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('jenis_kelamin') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Tempat Lahir
                        </label>
                        <input
                            type="text"
                            id="tempat_lahir"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('tempat_lahir') border-red-500 @enderror"
                        />
                        @error('tempat_lahir')
                            <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Lahir
                        </label>
                        <input
                            type="date"
                            id="tanggal_lahir"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', is_string($siswa->tanggal_lahir) ? $siswa->tanggal_lahir : $siswa->tanggal_lahir?->format('Y-m-d')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('tanggal_lahir') border-red-500 @enderror"
                        />
                        @error('tanggal_lahir')
                            <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Agama -->
                <div>
                    <label for="agama" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Agama
                    </label>
                    <select
                        id="agama"
                        name="agama"
                        required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('agama') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{ old('agama', $siswa->agama) === 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama', $siswa->agama) === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama', $siswa->agama) === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $siswa->agama) === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $siswa->agama) === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama', $siswa->agama) === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('agama')
                        <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Alamat
                    </label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('alamat') border-red-500 @enderror"
                    >{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-blue-800 dark:text-blue-200 text-sm flex items-start">
                        <i class="fas fa-info-circle mr-2 flex-shrink-0 mt-0.5"></i>
                        <span>NIS dan Email tidak dapat diubah. Hubungi admin jika ada data yang salah.</span>
                    </p>
                </div>

                <!-- Submit & Cancel -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('siswa.profil.show') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
