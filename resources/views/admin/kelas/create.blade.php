@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Kelas</h1>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('admin.kelas.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: X A, XI B" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                        @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Ruang</label>
                        <input type="text" name="ruang" value="{{ old('ruang') }}" placeholder="Contoh: 101, 201" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Wali Kelas <span class="text-red-500">*</span></label>
                        <select name="wali_guru_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('wali_guru_id') border-red-500 @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru_list as $g)
                                <option value="{{ $g->id }}" @selected(old('wali_guru_id') == $g->id)>{{ $g->nama_lengkap }} ({{ $g->spesialisasi ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        @error('wali_guru_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kapasitas <span class="text-red-500">*</span></label>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" required min="1" placeholder="Jumlah siswa maksimal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kapasitas') border-red-500 @enderror">
                        @error('kapasitas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-700"><i class="fas fa-info-circle mr-2"></i><strong>Info:</strong> Wali kelas adalah guru yang bertanggung jawab atas kelas ini</p>
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Kelas
                    </button>
                    <a href="{{ route('admin.kelas.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
