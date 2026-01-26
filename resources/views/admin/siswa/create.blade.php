@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Siswa Baru</h1>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('admin.siswa.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nis') border-red-500 @enderror">
                        @error('nis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror">
                        @error('nama_lengkap') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <select name="kelas_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas_list as $k)
                                <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih</option>
                            <option value="laki-laki" @selected(old('jenis_kelamin') == 'laki-laki')>Laki-laki</option>
                            <option value="perempuan" @selected(old('jenis_kelamin') == 'perempuan')>Perempuan</option>
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
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
