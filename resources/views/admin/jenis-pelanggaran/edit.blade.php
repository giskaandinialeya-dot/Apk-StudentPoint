@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Jenis Pelanggaran</h1>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('admin.jenis-pelanggaran.update', $jenis) }}" class="space-y-6">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $jenis->nama) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                        @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Poin <span class="text-red-500">*</span></label>
                        <input type="number" name="poin" value="{{ old('poin', $jenis->poin) }}" required min="1" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('poin') border-red-500 @enderror">
                        @error('poin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori_options as $key => $label)
                                <option value="{{ $key }}" @selected(old('kategori', $jenis->kategori) == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Auto SP Level</label>
                        <select name="auto_sp_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Tidak Ada</option>
                            <option value="1" @selected(old('auto_sp_level', $jenis->auto_sp_level) == '1')>Level 1</option>
                            <option value="2" @selected(old('auto_sp_level', $jenis->auto_sp_level) == '2')>Level 2</option>
                            <option value="3" @selected(old('auto_sp_level', $jenis->auto_sp_level) == '3')>Level 3</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="aktif" @selected(old('status', $jenis->status) == 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $jenis->status) == 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan', $jenis->keterangan) }}</textarea>
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
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
