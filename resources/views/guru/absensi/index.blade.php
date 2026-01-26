@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Absensi Siswa</h1>
                <p class="text-gray-600"><i class="fas fa-calendar-check"></i> Kelola absensi harian siswa</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('guru.absensi.bulk-today') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>Input Absensi Hari Ini
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form action="{{ route('guru.absensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Tanggal Filter -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-calendar text-blue-600 mr-2"></i>Tanggal
                </label>
                <input type="date" name="tanggal" value="{{ $tanggal_filter }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>Status
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Status --</option>
                    @foreach($status_options as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Absensi Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">NIS</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Tanggal</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Keterangan</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($absentis as $absensi)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ $absensi->siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $absensi->siswa->nis }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $absensi->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColors = [
                                        'hadir' => 'bg-green-100 text-green-800',
                                        'sakit' => 'bg-yellow-100 text-yellow-800',
                                        'izin' => 'bg-blue-100 text-blue-800',
                                        'alfa' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$absensi->status] ?? 'bg-gray-100' }}">
                                    {{ $status_options[$absensi->status] ?? ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $absensi->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('guru.absensi.edit', $absensi) }}" class="inline-block px-3 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl text-gray-400 mb-2 block"></i>
                                <p class="font-medium">Belum ada data absensi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($absentis->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $absentis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
