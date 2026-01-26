@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Daftar Prestasi</h1>
                <p class="text-gray-600 mt-1">Kelola prestasi siswa</p>
            </div>
            <a href="{{ route('guru.prestasi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                + Tambah Prestasi
            </a>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow mb-6 p-6">
            <form method="GET" action="{{ route('guru.prestasi.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                    <select name="siswa_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Semua Siswa</option>
                        @foreach($daftar_siswa as $siswa)
                            <option value="{{ $siswa->id }}" @selected(request('siswa_id') == $siswa->id)>
                                {{ $siswa->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Semua Kategori</option>
                        <option value="akademik" @selected(request('kategori') == 'akademik')>Akademik</option>
                        <option value="non-akademik" @selected(request('kategori') == 'non-akademik')>Non-Akademik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Success/Error Messages -->
        @if($message = session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ $message }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Siswa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Poin</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($prestasis as $prestasi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900 font-medium">
                                {{ $prestasi->siswa->nama_lengkap }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    @if($prestasi->kategori === 'akademik') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('-', ' ', $prestasi->kategori)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-green-600">+{{ $prestasi->poin }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($prestasi->deskripsi, 30) }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $prestasi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('guru.prestasi.edit', $prestasi) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('guru.prestasi.destroy', $prestasi) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data prestasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $prestasis->links() }}
        </div>
    </div>
</div>
@endsection
