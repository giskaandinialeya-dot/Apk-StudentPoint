@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Jenis Pelanggaran</h1>
            <a href="{{ route('admin.jenis-pelanggaran.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                <i class="fas fa-plus mr-2"></i>Tambah Jenis Pelanggaran
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.jenis-pelanggaran.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau keterangan..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori_options as $key => $label)
                            <option value="{{ $key }}" @selected(request('kategori') == $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') == 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(request('status') == 'nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-lg font-semibold text-center">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if($jenis_list->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold">Poin</th>
                            <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                            <th class="px-6 py-4 text-left font-semibold">Auto SP</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($jenis_list as $j)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $j->nama }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                        {{ $j->poin }} poin
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                        @if($j->kategori == 'ringan') bg-yellow-100 text-yellow-800
                                        @elseif($j->kategori == 'sedang') bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($j->kategori) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $j->auto_sp_level ? 'Level ' . $j->auto_sp_level : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold @if($j->status == 'aktif') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($j->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.jenis-pelanggaran.edit', $j) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.jenis-pelanggaran.destroy', $j) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $jenis_list->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">Belum ada data jenis pelanggaran</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
