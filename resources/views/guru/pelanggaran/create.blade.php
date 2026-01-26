@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Tambah Pelanggaran</h1>
                <p class="text-gray-600"><i class="fas fa-plus-circle"></i> Catat pelanggaran siswa baru</p>
            </div>
        </div>
    </div>

    <!-- Debug Info -->
    @if(app()->isLocal())
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 max-w-2xl mx-auto">
        <h3 class="font-bold text-blue-900 mb-2">🔍 Debug Info:</h3>
        <p class="text-sm text-blue-800">Siswa count: <strong>{{ isset($siswas) ? $siswas->count() : 'NOT SET' }}</strong></p>
        <p class="text-sm text-blue-800">Jenis Pelanggaran count: <strong>{{ isset($jenis_pelanggarans) ? $jenis_pelanggarans->count() : 'NOT SET' }}</strong></p>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto" data-aos="fade-up">
        <form action="{{ route('guru.pelanggaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Siswa Selection -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-user text-red-600 mr-2"></i>Pilih Siswa
                </label>
                <select name="siswa_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas ?? [] as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Pelanggaran -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-list text-red-600 mr-2"></i>Jenis Pelanggaran
                    <button type="button" onclick="showJenisModal()" class="ml-2 text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">+ Tambah Baru</button>
                </label>
                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">-- Pilih Jenis --</option>
                    @if(isset($jenis_pelanggarans))
                        @foreach($jenis_pelanggarans as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama }} ({{ $jenis->poin ?? 0 }} poin)</option>
                        @endforeach
                    @else
                        <option value="" disabled>ERROR: Variable jenis_pelanggarans tidak ada</option>
                    @endif
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
                <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Jam -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-clock text-red-600 mr-2"></i>Jam Pelanggaran
                </label>
                <input type="time" name="jam" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('jam')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-align-left text-red-600 mr-2"></i>Deskripsi / Keterangan
                </label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Jelaskan detail pelanggaran..."></textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti File -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">
                    <i class="fas fa-file-upload text-red-600 mr-2"></i>Bukti / Foto (Opsional)
                </label>
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
                        <input type="radio" name="status" value="aktif" checked class="w-4 h-4 text-red-600">
                        <span class="text-gray-900 font-semibold">Aktif</span>
                        <span class="text-gray-500 text-sm">(Pelanggaran berlaku)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="selesai" class="w-4 h-4 text-green-600">
                        <span class="text-gray-900 font-semibold">Selesai</span>
                        <span class="text-gray-500 text-sm">(Sudah ditindaklanjuti)</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Pelanggaran
                </button>
                <a href="{{ route('guru.pelanggaran.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Jenis Pelanggaran -->
<div id="jenisModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tambah Jenis Pelanggaran Baru</h2>
        
        <div id="jenisErrorMsg" class="mb-4 p-4 bg-red-50 border border-red-300 rounded-lg text-red-700 hidden">
            <i class="fas fa-exclamation-circle mr-2"></i><span id="jenisErrorText"></span>
        </div>

        <form id="jenisForm" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Nama Pelanggaran</label>
                <input type="text" id="jenis_nama" name="nama" placeholder="Cth: Terlambat masuk" maxlength="100" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Kategori</label>
                <select id="jenis_kategori" name="kategori" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="ringan">🟢 Ringan (Peringatan)</option>
                    <option value="sedang">🟡 Sedang (Hukuman)</option>
                    <option value="berat">🔴 Berat (Tindakan Khusus)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Poin (1-100)</label>
                <input type="number" id="jenis_poin" name="poin" placeholder="Cth: 5" min="1" max="100" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeJenisModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showJenisModal() {
        document.getElementById('jenisModal').style.display = 'flex';
        document.getElementById('jenis_nama').focus();
    }

    function closeJenisModal() {
        document.getElementById('jenisModal').style.display = 'none';
        document.getElementById('jenisForm').reset();
        document.getElementById('jenisErrorMsg').classList.add('hidden');
    }

    document.getElementById('jenisForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const nama = document.getElementById('jenis_nama').value.trim();
        const poin = parseInt(document.getElementById('jenis_poin').value);
        const kategori = document.getElementById('jenis_kategori').value;
        
        if (!nama || !poin || !kategori) {
            showJenisError('Semua field harus diisi');
            return;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showJenisError('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            const response = await fetch('{{ route("guru.jenis-pelanggaran.quick-add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ nama, poin, kategori })
            });

            // Check if response is valid JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                showJenisError('Server error - response bukan JSON. Status: ' + response.status);
                return;
            }

            const data = await response.json();

            if (data.success) {
                // Add new option to dropdown
                const select = document.getElementById('jenis_pelanggaran_id');
                const option = document.createElement('option');
                option.value = data.id;
                option.textContent = `${data.nama} (${data.poin} poin)`;
                option.selected = true;
                select.appendChild(option);

                // Show success message
                showJenisSuccess(`Jenis pelanggaran "${data.nama}" berhasil ditambahkan!`);
                
                // Close modal after 1.5 seconds
                setTimeout(() => {
                    closeJenisModal();
                }, 1500);
            } else {
                showJenisError(data.message || 'Gagal menambahkan jenis pelanggaran');
            }
        } catch (error) {
            console.error('Error:', error);
            showJenisError('Terjadi kesalahan: ' + error.message);
        }
    });

    function showJenisError(message) {
        const errorDiv = document.getElementById('jenisErrorMsg');
        document.getElementById('jenisErrorText').textContent = message;
        errorDiv.classList.remove('hidden');
    }

    function showJenisSuccess(message) {
        const errorDiv = document.getElementById('jenisErrorMsg');
        errorDiv.classList.remove('hidden');
        errorDiv.classList.remove('bg-red-50', 'border-red-300', 'text-red-700');
        errorDiv.classList.add('bg-green-50', 'border-green-300', 'text-green-700');
        document.getElementById('jenisErrorText').innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + message;
    }

    // Close modal when clicking outside
    document.getElementById('jenisModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeJenisModal();
        }
    });
</script>
@endsection

