@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Jenis Pelanggaran</h1>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('admin.jenis-pelanggaran.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Terlambat, Tidak Mengerjakan PR" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                        @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Poin <span class="text-red-500">*</span></label>
                        <input type="number" name="poin" value="{{ old('poin') }}" required min="1" max="100" placeholder="Jumlah poin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('poin') border-red-500 @enderror">
                        @error('poin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori_options as $key => $label)
                                <option value="{{ $key }}" @selected(old('kategori') == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Auto SP Level</label>
                        <select name="auto_sp_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Tidak Ada</option>
                            <option value="1" @selected(old('auto_sp_level') == '1')>Level 1</option>
                            <option value="2" @selected(old('auto_sp_level') == '2')>Level 2</option>
                            <option value="3" @selected(old('auto_sp_level') == '3')>Level 3</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="aktif" @selected(old('status') == 'aktif' || !old('status'))>Aktif</option>
                            <option value="nonaktif" @selected(old('status') == 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi atau penjelasan pelanggaran"></textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-700"><i class="fas fa-info-circle mr-2"></i><strong>Info:</strong> Poin digunakan untuk menghitung total pelanggaran siswa. Auto SP Level otomatis membuat surat peringatan.</p>
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Jenis Pelanggaran
                    </button>
                    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
