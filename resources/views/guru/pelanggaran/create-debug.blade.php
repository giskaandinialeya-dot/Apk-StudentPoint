@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2">Tambah Pelanggaran</h1>
        <p class="text-gray-600">Catat pelanggaran siswa baru</p>
    </div>

    <!-- Debug Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="font-bold text-blue-900 mb-2">Debug Info:</h3>
        <p class="text-blue-800">siswas variable count: {{ isset($siswas) ? $siswas->count() : 'NOT SET' }}</p>
        <p class="text-blue-800">jenis_pelanggarans variable count: {{ isset($jenisPelanggarans) ? $jenisPelanggarans->count() : 'NOT SET' }}</p>
        @if(!isset($jenisPelanggarans))
            <p class="text-red-600">⚠️ jenis_pelanggarans variable is MISSING!</p>
        @elseif($jenisPelanggarans->count() === 0)
            <p class="text-red-600">⚠️ jenis_pelanggarans is EMPTY! (count = 0)</p>
        @else
            <p class="text-green-600">✓ jenis_pelanggarans has {{ $jenisPelanggarans->count() }} items</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        <form action="{{ route('guru.pelanggaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Siswa -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Siswa</label>
                <select name="siswa_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas ?? [] as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Pelanggaran -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Jenis Pelanggaran</label>
                <select name="jenis_pelanggaran_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-- Pilih Jenis --</option>
                    @if(isset($jenisPelanggarans) && $jenisPelanggarans->count() > 0)
                        @foreach($jenisPelanggarans as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama }} ({{ $jenis->poin }} poin)</option>
                        @endforeach
                    @else
                        <option value="" disabled>Tidak ada jenis pelanggaran tersedia</option>
                    @endif
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Jelaskan detail pelanggaran..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Simpan Pelanggaran
                </button>
                <a href="{{ route('guru.pelanggaran.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
