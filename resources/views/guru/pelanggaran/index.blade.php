@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Riwayat Pelanggaran</h1>
                <p class="text-gray-600"><i class="fas fa-list"></i> Daftar lengkap pelanggaran siswa</p>
            </div>
            <a href="{{ route('guru.pelanggaran.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                Tambah Pelanggaran
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8" data-aos="fade-up">
        <div class="bg-white rounded-lg shadow-md p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Siswa</label>
            <input type="text" placeholder="Cari siswa..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Pelanggaran</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <option>Semua</option>
                <option>Terlambat</option>
                <option>Tidak Mengerjakan PR</option>
                <option>Berbicara Kasar</option>
            </select>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <option>Semua</option>
                <option>Aktif</option>
                <option>Diselesaikan</option>
            </select>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-red-500" data-aos="fade-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Pelanggaran</p>
                    <p class="text-4xl font-bold text-red-600 mt-2">{{ $pelanggarans->count() ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-orange-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pelanggaran Aktif</p>
                    <p class="text-4xl font-bold text-orange-600 mt-2">{{ $pelanggarans->where('status', 'aktif')->count() ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pelanggaran Hari Ini</p>
                    <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $pelanggarans->count() ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-today text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-hashtag text-gray-600 mr-2"></i>No
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-user text-gray-600 mr-2"></i>Siswa
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-list-check text-gray-600 mr-2"></i>Jenis Pelanggaran
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-star text-gray-600 mr-2"></i>Poin
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-calendar text-gray-600 mr-2"></i>Tanggal
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>Status
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">
                            <i class="fas fa-cog text-gray-600 mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pelanggarans as $pelanggaran)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($pelanggaran->siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $pelanggaran->siswa->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">NIS: {{ $pelanggaran->siswa->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $pelanggaran->jenisPelanggaran->nama ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $pelanggaran->deskripsi ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $pelanggaran->jenisPelanggaran->poin ?? 0 }} poin
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2"></i>{{ $pelanggaran->tanggal->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold {{ $pelanggaran->status === 'aktif' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                                    @if($pelanggaran->status === 'aktif')
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                    {{ ucfirst($pelanggaran->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('guru.pelanggaran.edit', $pelanggaran) }}" class="inline-flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg transition-colors text-sm font-semibold">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <button onclick="deleteRecord({{ $pelanggaran->id }})" class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg transition-colors text-sm font-semibold">
                                        <i class="fas fa-trash"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 mb-2 block"></i>
                                <p class="text-gray-500 font-semibold">Tidak ada pelanggaran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($pelanggarans->hasPages())
        <div class="mt-8">
            {{ $pelanggarans->links() }}
        </div>
    @endif
</div>

<script>
function deleteRecord(id) {
    if (confirm('Yakin ingin menghapus?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
