@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Edit Pelanggaran</h1>
                <p class="text-gray-600"><i class="fas fa-edit"></i> Ubah data pelanggaran siswa</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto" data-aos="fade-up">
        <form action="{{ route('guru.pelanggaran.update', $pelanggaran) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Siswa Selection -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-user text-red-600 mr-2"></i>Siswa
                </label>
                <input type="text" disabled value="{{ $pelanggaran->siswa->nama_lengkap }} ({{ $pelanggaran->siswa->nis }})" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                <input type="hidden" name="siswa_id" value="{{ $pelanggaran->siswa_id }}">
            </div>

            <!-- Jenis Pelanggaran -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-list text-red-600 mr-2"></i>Jenis Pelanggaran
                </label>
                <select name="jenis_pelanggaran_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenis_pelanggarans ?? [] as $jenis)
                        <option value="{{ $jenis->id }}" {{ $pelanggaran->jenis_pelanggaran_id == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama }} ({{ $jenis->poin }} poin)
                        </option>
                    @endforeach
                </select>
                @error('jenis_pelanggaran_id')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-calendar text-red-600 mr-2"></i>Tanggal Pelanggaran
                </label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Jam -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-clock text-red-600 mr-2"></i>Jam Pelanggaran
                </label>
                <input type="time" name="jam" value="{{ old('jam', $pelanggaran->jam) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('jam')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-align-left text-red-600 mr-2"></i>Deskripsi / Keterangan
                </label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti File -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-file-upload text-red-600 mr-2"></i>Bukti / Foto (Opsional)
                </label>
                @if($pelanggaran->bukti_file)
                    <p class="text-gray-600 text-sm mb-2"><i class="fas fa-check-circle text-green-600"></i> File sudah tersimpan: {{ $pelanggaran->bukti_file }}</p>
                @endif
                <input type="file" name="bukti_file" accept="image/*,application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG, PDF (Max 5MB)</p>
                @error('bukti_file')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-info-circle text-red-600 mr-2"></i>Status
                </label>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="aktif" {{ $pelanggaran->status === 'aktif' ? 'checked' : '' }} class="w-4 h-4 text-red-600">
                        <span class="text-gray-900 font-semibold">Aktif</span>
                        <span class="text-gray-500 text-sm">(Pelanggaran berlaku)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="selesai" {{ $pelanggaran->status === 'selesai' ? 'checked' : '' }} class="w-4 h-4 text-green-600">
                        <span class="text-gray-900 font-semibold">Selesai</span>
                        <span class="text-gray-500 text-sm">(Sudah ditindaklanjuti)</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('guru.pelanggaran.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="button" onclick="confirmDelete()" class="flex-1 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Hapus Pelanggaran?</h2>
        <p class="text-gray-600 mb-6">Pelanggaran siswa <strong>{{ $pelanggaran->siswa->nama_lengkap }}</strong> akan dihapus dan poin akan dikurangi secara otomatis.</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-4 py-2 rounded-lg font-semibold transition-colors">
                <i class="fas fa-times mr-2"></i>Batal
            </button>
            <form id="deleteForm" action="{{ route('guru.pelanggaran.destroy', $pelanggaran) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        document.getElementById('deleteModal').style.display = 'flex';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
