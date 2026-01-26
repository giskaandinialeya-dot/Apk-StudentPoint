@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Edit Absensi</h1>
            <p class="text-gray-600"><i class="fas fa-edit"></i> Edit data absensi siswa</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        <form action="{{ route('guru.absensi.update', $absensi) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Siswa Info (Read-only) -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Siswa</label>
                <div class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg">
                    <p class="font-semibold text-gray-900">{{ $absensi->siswa->nama_lengkap }}</p>
                    <p class="text-sm text-gray-600">NIS: {{ $absensi->siswa->nis }}</p>
                </div>
            </div>

            <!-- Tanggal (Read-only) -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Tanggal</label>
                <div class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg">
                    <p class="font-semibold text-gray-900">{{ $absensi->tanggal->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-3">
                    <i class="fas fa-flag text-blue-600 mr-2"></i>Status
                </label>
                <div class="space-y-2">
                    @foreach($status_options as $status_key => $status_label)
                        @php
                            $colors = [
                                'hadir' => 'border-green-500 bg-green-50',
                                'sakit' => 'border-yellow-500 bg-yellow-50',
                                'izin' => 'border-blue-500 bg-blue-50',
                                'alfa' => 'border-red-500 bg-red-50',
                            ];
                        @endphp
                        <label class="flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition-all {{ $colors[$status_key] ?? 'border-gray-300' }} {{ $absensi->status === $status_key ? 'border-' . ($status_key === 'hadir' ? 'green' : ($status_key === 'sakit' ? 'yellow' : ($status_key === 'izin' ? 'blue' : 'red'))) . '-700' : '' }}">
                            <input type="radio" name="status" value="{{ $status_key }}" {{ $absensi->status === $status_key ? 'checked' : '' }} required class="w-4 h-4">
                            <span class="font-semibold">{{ $status_label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('status')
                    <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-align-left text-blue-600 mr-2"></i>Keterangan (Opsional)
                </label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Anak demam tinggi, Izin ke dokter, dll...">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('guru.absensi.index', ['tanggal' => $absensi->tanggal->format('Y-m-d')]) }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
